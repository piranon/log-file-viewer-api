<?php

namespace LogFileViewer\Controller;

use LogFileViewer\Exception\VerifiedPathFileException;
use LogFileViewer\Validator\GetFileContentValidator;
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
        $filePath = '/' . $filePath;

        /** @var GetFileContentValidator $getFileContentValidator */
        $getFileContentValidator = $this->container->get('validate.getFileContent');

        try {
            $getFileContentValidator->verifiedPathFile($filePath);
            $getFileContentValidator->isFileExists($filePath);
        } catch (\Exception $e) {
            return $response->withJson(
                ['error' => ['code' => $e->getCode(), 'message' => $e->getMessage()]],
                $e->getCode()
            );
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
