<?php

namespace LogFileViewer\Exception;

/**
 * Class FileNotFoundException
 * @package LogFileViewer\Exception
 */
class FileNotFoundException extends \Exception
{
    /**
     * FileNotFoundException constructor.
     * @param null $message
     * @param int $code
     * @param \Exception|null $previous
     */
    public function __construct($message = null, $code = 404, \Exception $previous = null)
    {
        $message = $message ?: 'File not found.';
        parent::__construct($message, $code, $previous);
    }
}
