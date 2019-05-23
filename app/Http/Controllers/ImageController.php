<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
use Aws\S3\S3Client;

class ImageController extends Controller
{
    private $storage;
    private $img;

    public function __construct()
    {
        $this->storage = new S3Client([
            'region'          => 'us-east-1',
            'version'         => 'latest',
            'credentials' => ['key' => env('S3ACCESSID'), 'secret' => env('S3SECRET')]
        ]);

        $this->img = "assets/default-wine-image.png";
    }

    /**
     * @return string
     */
    public function getCurrentImg()
    {
        return $this->img;
    }

    /**
     * @param $img
     */
    public function overrideDefaultImage($img)
    {
        $this->img = $img;
    }

    /**
     * Mostly used for testing...
     *
     * @return S3Client
     */
    public function getStorageAccessor()
    {
        return $this->storage;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function upload(Request $request)
    {
        if ($request->hasFile('photo')) {
            $file = $request->file('photo');

            $fileName = "imgManageUpload".time().".".$file->getClientOriginalExtension();
            $mime = $file->getMimeType();

            $file->move(env('TMP_DIR'), $fileName);
            $path = env('TMP_DIR')."/".$fileName;

            $hash = md5(file_get_contents($path));
            $cacheRet = Redis::get($hash);
            $saveFileName = "$hash.".$file->getClientOriginalExtension();


            if ($cacheRet != null) {
                unlink($path);
                return response()->json(['set' => $cacheRet, 'file' => $saveFileName], 200);
            }


            try {
                $result = $this->storage->putObject([
                    'ACL' => 'public-read',
                    'Bucket' => env('BUCKET'),
                    'ContentType' => $mime,
                    'Key' => $saveFileName,
                    'ServerSideEncryption' => 'AES256',
                    'SourceFile' => $path,
                    'StorageClass' => 'REDUCED_REDUNDANCY',
                ]);
                $etag = (string)trim($result['ETag'], '"');
                if ($etag != $hash) {
                    //Problem Pushing to S3 Most Likely
                    throw new \Exception("MD5/eTag Mismatch");
                }
            } catch (\Exception $e) {
                dd($e->getAwsErrorMessage());
                return response()->json(['error' => $e->getMessage()], 401);
            }


            $setDate = date('c');
            Redis::set($hash, $setDate);
            return response()->json(['set' => $setDate, 'file' => $saveFileName], 200);
        }
    }

    /**
     * @param $id
     * @param int $height
     * @param int $width
     * @param int $timeout
     */
    private function display($id, $height = 0, $width = 0, $timeout = 0)
    {
        $image = new \Imagick();
        $image->readImage($this->img);

        if ($height > 0 && $width > 0) {
            if ($height > env("MAX_HEIGHT")) {
                $height = env('MAX_HEIGHT');
            }
            if ($width > env('MAX_WIDTH')) {
                $width = env("MAX_WIDTH");
            }

            $filter = \Imagick::FILTER_CUBIC;

            $image->resizeImage(
                $width,
                $height,
                $filter,
                0.5,
                true
            );
        }

        ob_start();
        echo $image;
        ob_clean();
        $len = $image->getImageLength();
        $mime = $image->getImageMimeType();



        header('Content-type: '.$mime);
        header('Pragma: public');
        //$timeout = <timeout>;
        //header('Expires: ' . gmdate("D, d M Y H:i:s", time() + $timeout) . " GMT");
        //header("Cache-Control: public, max-age=$timeout");
        header('Content-Length: '.$len);

        echo $image;
        ob_end_flush();
        $image->destroy();
    }

    /**
     * @param $url
     * @return bool
     */
    private function validateImg($url)
    {
        try {
            $h = get_headers($url);
            if ($h[0] == 'HTTP/1.1 200 OK') {
                $this->img = $url;
                return true;
            }
        } catch (\Exception $e) {
        }

        return false;
    }

    /**
     * @param $file
     */
    public function getImage($file)
    {
        $imgUrl = $this->storage->getObjectUrl(env('BUCKET'), $file);
        $this->validateImg($imgUrl);

        return $this->display($file);
    }

    /**
     * @param $file
     * @return string
     */
    public function getImageUrl($file)
    {
        $imgUrl = $this->storage->getObjectUrl(env('BUCKET'), $file);

        if ($this->validateImg($imgUrl)) {
            return response()->json(['url' => $imgUrl], 200);
        }
        return response()->json(['error' => 'No Such File'], 404);
    }

    /**
     * @param $file
     * @param $height
     * @param $width
     */
    public function getImageResized($file, $height, $width)
    {
        $imgUrl = $this->storage->getObjectUrl(env('BUCKET'), $file);

        $this->validateImg($imgUrl);
        return $this->display($file, $height, $width);
    }
}
