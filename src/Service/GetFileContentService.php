<?php

namespace LogFileViewer\Service;

/**
 * Class GetFileContentService
 * @package LogFileViewer\Service
 */
class GetFileContentService
{
    /**
     * @param string $pathToFile
     * @param int $offset
     * @param int $limit
     * @return array
     */
    public function getLineOfFileContent($pathToFile, $offset, $limit)
    {
        $f = fopen($pathToFile, 'r');
        $contents = [];
        $lineNumber = 0;

        while ($line = fgets($f)) {
            $lineNumber++;
            if ($lineNumber >= $offset && $lineNumber <= $limit) {
                $contents[] = ['line' => $lineNumber, 'text' => trim($line)];
            }
        }

        fclose($f);

        return ['data' => $contents, 'total_count' => $lineNumber];
    }
}
