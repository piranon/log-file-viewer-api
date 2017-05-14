<?php

namespace LogFileViewer\Validator;

use LogFileViewer\Exception\FileNotFoundException;
use LogFileViewer\Exception\VerifiedPathFileException;

/**
 * Class GetFileContentValidator
 * @package LogFileViewer\Validator
 */
class GetFileContentValidator
{
    /**
     * @param string $pathToFile
     * @return bool
     * @throws VerifiedPathFileException
     */
    public function verifiedPathFile($pathToFile)
    {
        if (stristr(PHP_OS, 'LINUX') OR stristr(PHP_OS, 'DAR')) {
            $this->verifiedUnixPathFile($pathToFile);
        } else {
            $this->verifiedWindowsPathFile($pathToFile);
        }

        return true;
    }

    /**
     * @param string $pathToFile
     * @return bool
     * @throws VerifiedPathFileException
     */
    public function verifiedUnixPathFile($pathToFile)
    {
        $pathToFile = substr($pathToFile, 1);
        $segments = explode('/', $pathToFile);
        if (!isset($segments[0]) || $segments[0] !== 'var' || !isset($segments[1]) || $segments[1] !== 'tmp') {
            throw new VerifiedPathFileException();
        }

        return true;
    }

    /**
     * @param string $pathToFile
     * @return bool
     * @throws VerifiedPathFileException
     */
    public function verifiedWindowsPathFile($pathToFile)
    {
        if (substr($pathToFile, 0, 7) !== 'C:\temp') {
            throw new VerifiedPathFileException();
        }

        return true;
    }

    /**
     * @param string $pathToFile
     * @return bool
     * @throws FileNotFoundException
     */
    public function isFileExists($pathToFile)
    {
        if (!is_file($pathToFile)) {
            throw new FileNotFoundException();
        }

        return true;
    }
}
