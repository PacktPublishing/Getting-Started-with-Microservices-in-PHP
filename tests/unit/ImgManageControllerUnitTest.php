<?php

use App\Http\Controllers\ImageController;

class ImgManageControllerUnitTest extends TestCase
{
    private $controller;

    public function setUp()
    {
        $this->controller = new ImageController();
        $this->controller->overrideDefaultImage("public/assets/default-wine-image.png");
        parent::setUp();
    }

    public function tearDown()
    {
        $this->controller = null;
        parent::tearDown();
    }

    /**
     * @covers App\Http\Controllers\ImageController::getCurrentImg
     * @covers App\Http\Controllers\ImageController::__construct
     */
    public function testGetCurrentDefaultImage()
    {
        $ret = $this->controller->getCurrentImg();
        $this->assertEquals("public/assets/default-wine-image.png", $ret);
    }

    /**
     * @covers App\Http\Controllers\ImageController::overrideDefaultImage
     * @uses App\Http\Controllers\ImageController::getCurrentImg
     */
    public function testSettingOfOverrideImage()
    {
        $this->controller->overrideDefaultImage("blah");
        $ret = $this->controller->getCurrentImg();
        $this->assertEquals("blah", $ret);
    }

    /**
     * @covers App\Http\Controllers\ImageController::validateImg
     * @covers App\Http\Controllers\ImageController::getStorageAccessor
     */
    public function testValidateImgSuccess()
    {
        $storage = $this->controller->getStorageAccessor();
        $this->assertInstanceOf(\Aws\S3\S3Client::class, $storage);
        $url = $storage->getObjectUrl(env('BUCKET'), "default_user.jpg");
        $ret = $this->invokeMethod($this->controller, 'validateImg', [$url]);
        $this->assertTrue($ret);
    }

    /**
     * @covers App\Http\Controllers\ImageController::validateImg
     */
    public function testValidateImgFail()
    {
        $url = "http://made-uo.to.fail";
        $ret = $this->invokeMethod($this->controller, 'validateImg', [$url]);
        $this->assertFalse($ret);
    }
}
