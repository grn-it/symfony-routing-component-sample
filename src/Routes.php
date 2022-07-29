<?php

namespace App;

require_once __DIR__.'/../vendor/autoload.php';

use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;

$context = new RequestContext();
$routes = new RouteCollection();

$routes->add(
    'index',
    new Route('/', ['_controller' => static function() { return json_encode(['message' => 'Hello. This is index page']); }])
);
$routes->add(
    'messages_list',
    new Route('messages', ['_controller' => 'App\Controller\MessageController::list'])
);
$routes->add(
    'messages_item',
    new Route('messages/{id}', ['_controller' => 'App\Controller\MessageController::item'])
);
