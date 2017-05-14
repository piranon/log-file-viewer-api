<?php
require '../vendor/autoload.php';

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

$env = getenv('APP_ENV') ? : 'dev';

$settings = require __DIR__ . "/../app/setting/settings.$env.php";
$app = new \Slim\App($settings);

// Fetch DI Container
$container = $app->getContainer();

$container['notFoundHandler'] = function () {
    return function ($request, $response) {
        return $response->withJson(['error' => [
            'code' => 404,
            'message' => 'Resource does not exist.'
        ]], 404);
    };
};

$app->get('/files[/{filePath:.*}]', function (Request $request, Response $response) {
    $filePath = $request->getAttribute('filePath');
    $segments = explode('/', $filePath);
    if (!isset($segments[0]) || $segments[0] !== 'var' || !isset($segments[1]) || $segments[1] !== 'tmp') {
        return $response->withJson(['error' => [
            'code' => 400,
            'message' => 'Path file must under /var/tmp'
        ]], 400);
    }
});

$app->run();