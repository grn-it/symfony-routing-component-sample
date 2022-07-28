<?php

namespace App;

use Symfony\Component\Routing\Generator\UrlGenerator;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;

require_once __DIR__.'/../vendor/autoload.php';

$routes = new RouteCollection();

$routes->add(
    'index',
    new Route('/', ['_controller' => static function() { return 'index'; }])
);
$routes->add(
    'messages_list', 
    new Route('messages', ['_controller' => 'App\Controller\MessageController::list'])
);
$routes->add(
    'messages_item',
    new Route('messages/{id}', ['_controller' => 'App\Controller\MessageController::item'])
);
$routes->add(
    'generator_url_messages_item',
    new Route('generator-url/messages-item', ['_controller' => 'App\Controller\GeneratorUrlController::messagesItem'])
);


$context = new RequestContext();

$matcher = new UrlMatcher($routes, $context);
$parameters = $matcher->match($_SERVER['REQUEST_URI']);

if ($parameters['_controller'] instanceof \Closure) {
    echo $parameters['_controller']();
} else {
    $callable = explode('::', $parameters['_controller']);
    $object = new $callable[0]();
    $method = $callable[1];
    
    switch ($parameters['_route']) {
        case 'generator_url_messages_item': {
            echo $object->$method(new UrlGenerator($routes, $context));
            break;
        }
        case 'messages_item': {
            echo $object->$method($parameters['id']);
            break;
        }
        default:
            echo $object->$method();
    }
}
