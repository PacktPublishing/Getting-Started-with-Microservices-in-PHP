<?php
class ApiCest 
{
    /**
     * @param ApiTester $I
     * @group integration
     */
    public function tryApi(ApiTester $I)
    {
        $I->sendGET('/image/url/default_user.jpg');
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
    }
}