<?php

namespace LogFileViewer\Exception;

/**
 * Class VerifiedPathFileException
 * @package LogFileViewer\Exception
 */
class VerifiedPathFileException extends \Exception
{
    /**
     * VerifiedPathFileException constructor.
     * @param null $message
     * @param int $code
     * @param \Exception|null $previous
     */
    public function __construct($message = null, $code = 400, \Exception $previous = null)
    {
        $message = $message ?: 'Path file must under /var/tmp';
        parent::__construct($message, $code, $previous);
    }
}
