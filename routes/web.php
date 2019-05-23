<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$app->get('/', function () use ($app) {
    return $app->version();
});


/**
 * @api {post} /image Publish New Image to service
 * @apiName newImage
 * @apiGroup Image
 *
 * @apiParam {File} photo  Image To Be Stored.
 *
 * @apiSuccess {String} set Date/Time that the image was stored.
 * @apiSuccess {String} file  Name of the file to reference.
 *
 * @apiSuccessExample {json} Success-Response:
 *     HTTP/1.1 200 OK
 *     {
 *      "set": "2017-05-18T23:54:43+00:00",
 *      "file": "abee860e6b8ac692751cc20ab95befc5.JPG"
 *     }
 *
 * @apiError Error Inability to store the image, retry.
 *
 */
$app->post('/image', 'ImageController@upload');

/**
 * @api {get} /image/url/{file} Get an Image Url for a specified file
 * @apiName getImageUrl
 * @apiGroup Image
 *
 * @apiParam {String} file  The File Key requested.
 *
 * @apiSuccess {String} url The publicly Accessible URL
 *
 * @apiSuccessExample {json} Success-Response:
 *     HTTP/1.1 200 OK
 *     {
 *      {"url":"https:www.example.com/image.jpg"}
 *     }
 *
 * @apiError Error Inability to store the image, retry.
 * @apiErrorExample {json} Error-Response:
 *     HTTP/1.1 404 Not Found
 *     {
 *       "error":"No Such File"
 *     }
 */
$app->get('/image/url/{file}', 'ImageController@getImageUrl');

/**
 * @api {get} /image/{file} Get an Image Base File, no resizing done
 * @apiName getImageFile
 * @apiGroup Image
 *
 * @apiParam {String} file  The File Key requested.
 *
 * @apiSuccess {String} image The Actual Image
 */
$app->get('/image/{file}', 'ImageController@getImage');

/**
 * @api {get} /image/{file}/size/{height}x{width} Get an Image resized
 * @apiName getImageFileResized
 * @apiGroup Image
 *
 * @apiParam {String} file  The File Key requested.
 * @apiParam {String} height The Height for the image
 * @apiParam {String} width The Width of the image
 *
 * @apiSuccess {String} image The Actual Image
 */
$app->get('/image/{file}/size/{height}x{width}', 'ImageController@getImageResized');
