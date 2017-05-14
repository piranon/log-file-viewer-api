<?php

namespace LogFileViewer\Validator;

use LogFileViewer\Exception\VerifiedPathFileException;

/**
 * Class GetFileContentValidator
 * @package LogFileViewer\Validator
 */
class GetFileContentValidator
{
    /**
     * @param $pathToFile
     * @throws VerifiedPathFileException
     */
    public function verifiedPathFile($pathToFile)
    {
        $segments = explode('/', $pathToFile);
        if (!isset($segments[0]) || $segments[0] !== 'var' || !isset($segments[1]) || $segments[1] !== 'tmp') {
            throw new VerifiedPathFileException();
        }
    }
}
