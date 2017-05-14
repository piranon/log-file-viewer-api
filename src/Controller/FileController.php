<?php

namespace LogFileViewer\Controller;

use LogFileViewer\Exception\VerifiedPathFileException;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

/**
 * Class FileController
 * @package LogFileViewer\Controller
 */
class FileController
{
    /**
     * @var ContainerInterface
     */
    protected $container;

    /**
     * FileController constructor.
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container) {
        $this->container = $container;
    }

    /**
     * @param Request $request
     * @param Response $response
     * @return mixed
     */
    public function getContentAction(Request $request, Response $response) {
        $filePath = $request->getAttribute('filePath');

        try {
            $this->container->get('validate.getFileContent')->verifiedPathFile($filePath);
        } catch (VerifiedPathFileException $e) {
            return $response->withJson(
                ['error' => ['code' => $e->getCode(), 'message' => $e->getMessage()]],
                $e->getCode()
            );
        }


        $filePath = '/' . $filePath;

        if (!file_exists($filePath)) {
            return $response->withJson(['error' => [
                'code' => 404,
                'message' => 'File not found.'
            ]], 404);
        }

        $lines = explode(',', $request->getQueryParam('lines', '0,10'));

        $f = fopen($filePath, 'r');
        $contents = [];
        $lineNumber = 0;
        $offset = (int) $lines[0];
        $limit = (int) $lines[1];

        while ($line = fgets($f)) {
            $lineNumber++;
            if ($lineNumber >= $offset && $lineNumber <= $limit) {
                $contents[] = ['line' => $lineNumber, 'text' => trim($line)];
            }
        }

        fclose($f);

        return $response
            ->withJson(['data' => $contents, 'total_count' => $lineNumber], 200);
    }
}
