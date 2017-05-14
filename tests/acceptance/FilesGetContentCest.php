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

    public function getFileContentNoParameterTest(AcceptanceTester $I)
    {
        $I->sendGET('files/var/tmp/access_log.1');
        $I->seeResponseCodeIs(200);
        $I->seeResponseContainsJson([
            'data' => [
                ['line' => 1, 'text' => '64.242.88.10 - - [07/Mar/2004:16:05:49 -0800] "GET /twiki/bin/edit/Main/Double_bounce_sender?topicparent=Main.ConfigurationVariables HTTP/1.1" 401 12846'],
                ['line' => 2, 'text' => '64.242.88.10 - - [07/Mar/2004:16:06:51 -0800] "GET /twiki/bin/rdiff/TWiki/NewUserTemplate?rev1=1.3&rev2=1.2 HTTP/1.1" 200 4523'],
                ['line' => 3, 'text' => '64.242.88.10 - - [07/Mar/2004:16:10:02 -0800] "GET /mailman/listinfo/hsdivision HTTP/1.1" 200 6291'],
                ['line' => 4, 'text' => '64.242.88.10 - - [07/Mar/2004:16:11:58 -0800] "GET /twiki/bin/view/TWiki/WikiSyntax HTTP/1.1" 200 7352'],
                ['line' => 5, 'text' => '64.242.88.10 - - [07/Mar/2004:16:20:55 -0800] "GET /twiki/bin/view/Main/DCCAndPostFix HTTP/1.1" 200 5253'],
                ['line' => 6, 'text' => '64.242.88.10 - - [07/Mar/2004:16:23:12 -0800] "GET /twiki/bin/oops/TWiki/AppendixFileSystem?template=oopsmore¶m1=1.12¶m2=1.12 HTTP/1.1" 200 11382'],
                ['line' => 7, 'text' => '64.242.88.10 - - [07/Mar/2004:16:24:16 -0800] "GET /twiki/bin/view/Main/PeterThoeny HTTP/1.1" 200 4924'],
                ['line' => 8, 'text' => '64.242.88.10 - - [07/Mar/2004:16:29:16 -0800] "GET /twiki/bin/edit/Main/Header_checks?topicparent=Main.ConfigurationVariables HTTP/1.1" 401 12851'],
                ['line' => 9, 'text' => '64.242.88.10 - - [07/Mar/2004:16:30:29 -0800] "GET /twiki/bin/attach/Main/OfficeLocations HTTP/1.1" 401 12851'],
                ['line' => 10, 'text' => '64.242.88.10 - - [07/Mar/2004:16:31:48 -0800] "GET /twiki/bin/view/TWiki/WebTopicEditTemplate HTTP/1.1" 200 3732']
            ],
            'total_count' => 117
        ]);
    }
}
