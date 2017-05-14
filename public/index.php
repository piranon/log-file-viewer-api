<?php
require '../vendor/autoload.php';

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

$app->run();