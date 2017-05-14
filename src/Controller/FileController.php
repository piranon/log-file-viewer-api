<?php

namespace LogFileViewer\Controller;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Container\ContainerInterface;

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
        $segments = explode('/', $filePath);
        if (!isset($segments[0]) || $segments[0] !== 'var' || !isset($segments[1]) || $segments[1] !== 'tmp') {
            return $response->withJson(['error' => [
                'code' => 400,
                'message' => 'Path file must under /var/tmp'
            ]], 400);
        }

        $filePath = '/' . $filePath;

        if (!file_exists($filePath)) {
            return $response->withJson(['error' => [
                'code' => 404,
                'message' => 'File not found.'
            ]], 404);
        }
    }
}
