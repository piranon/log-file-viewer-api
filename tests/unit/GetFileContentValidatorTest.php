<?php

use LogFileViewer\Exception\VerifiedPathFileException;
use LogFileViewer\Validator\GetFileContentValidator;

class GetFileContentValidatorTest extends \PHPUnit_Framework_TestCase
{
    protected $getFileContentValidator;

    protected function setUp()
    {
        $this->getFileContentValidator = new GetFileContentValidator();
    }

    protected function tearDown()
    {
    }

    public function testVerifiedUnixPathFileSuccess()
    {
        $result = $this->getFileContentValidator->verifiedUnixPathFile('/var/tmp/log.log');
        $this->assertTrue($result);
    }

    public function testVerifiedUnixPathFileThrowError()
    {
        $this->expectException(VerifiedPathFileException::class);

        $this->getFileContentValidator->verifiedUnixPathFile('/etc/nginx/conf.d');
    }

    public function testVerifiedWindowsPathFileSuccess()
    {
        $result = $this->getFileContentValidator->verifiedWindowsPathFile('C:\temp\log.log');
        $this->assertTrue($result);
    }

    public function testVerifiedWindowsPathFileThrowError()
    {
        $this->expectException(VerifiedPathFileException::class);

        $this->getFileContentValidator->verifiedWindowsPathFile('C:\windows\log.log');
    }
}
