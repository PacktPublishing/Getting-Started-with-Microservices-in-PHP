<?php

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class ImgManageControllerTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testExample()
    {
        $this->get('/');

        $this->assertEquals(
            $this->app->version(),
            $this->response->getContent()
        );
    }

    /**
     * @covers App\Http\Controllers\ImageController::getImageUrl
     */
    public function testGetImageUrlGood()
    {
        $this->json('GET', '/image/url/default_user.jpg', [])
            ->seeJson(['url'=> env('S3LINK')."/default_user.jpg"]);
    }

    /**
     * @covers App\Http\Controllers\ImageController::getImageUrl
     */
    public function testGetImageUrlBad()
    {
        $this->json('GET', '/image/url/non-existant-image.jpg', [])
            ->seeJson(['error'=> "No Such File"]);
    }

    /**
     * @covers App\Http\Controllers\ImageController::getImage
     */
    public function testGetImageGood()
    {
        echo "Test1...\n";
        $response = $this->call('GET', '/image/default_user.jpg');
        //$this->assertEquals(200, $response->status());
        echo "Test2...\n";
        var_dump($response->status());
    }
}
