<?php

namespace LogFileViewer\Controller;

use LogFileViewer\Service\GetFileContentService;
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
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     * @param Request $request
     * @param Response $response
     * @return Response
     */
    public function getContentAction(Request $request, Response $response)
    {
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

        /** @var GetFileContentService $getFileContentService */
        $getFileContentService = $this->container->get('service.getFileContent');
        $responseData = $getFileContentService->getLineOfFileContent($filePath, $lines[0], $lines[1]);


        return $response->withJson($responseData, 200);
    }
}
