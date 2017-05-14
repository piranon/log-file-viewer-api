<?php
require '../vendor/autoload.php';

use Slim\App;
use LogFileViewer\Controller\FileController;

$env = getenv('APP_ENV') ? : 'dev';

$settings = require __DIR__ . "/../app/setting/settings.$env.php";
$app = new App($settings);

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

$app->get('/files[/{filePath:.*}]', FileController::class . ':getContentAction');
$app->run();