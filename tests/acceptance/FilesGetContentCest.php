<?php


class FilesGetContentCest
{
    public function _before(AcceptanceTester $I)
    {
    }

    public function _after(AcceptanceTester $I)
    {
    }

    public function getWrongEndpointTest(AcceptanceTester $I)
    {
        $I->sendGET('wrong_endpoint');
        $I->seeResponseCodeIs(404);
        $I->seeResponseEquals(['error' => [
            'code' => 404,
            'message' => 'Resource does not exist.'
        ]]);
    }
}
