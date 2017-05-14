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
        $I->seeResponseEquals(json_encode(['error' => [
            'code' => 404,
            'message' => 'Resource does not exist.'
        ]]));
    }

    public function getWrongPathTest(AcceptanceTester $I)
    {
        $I->sendGET('files/etc/nginx/conf.d/default.conf');
        $I->seeResponseCodeIs(400);
        $I->seeResponseEquals(json_encode(['error' => [
            'code' => 400,
            'message' => 'Path file must under /var/tmp'
        ]]));
    }

    public function getNotExistFileTest(AcceptanceTester $I)
    {
        $I->sendGET('files/var/tmp/not_exist_file');
        $I->seeResponseCodeIs(404);
        $I->seeResponseEquals(json_encode(['error' => [
            'code' => 404,
            'message' => 'File not found.'
        ]]));
    }
}
