<?php
require '../vendor/autoload.php';

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

$config = [
    'settings' => [
        'displayErrorDetails' => true,
    ]
];

$container = new \Slim\Container($config);

//Override the default Not Found Handler
$container['notFoundHandler'] = function () {
    return function ($request, $response) {
        return $response->withJson(['error' => [
            'code' => 404,
            'message' => 'Resource does not exist.'
        ]], 404);
    };
};

$app = new \Slim\App($container);

$app->run();