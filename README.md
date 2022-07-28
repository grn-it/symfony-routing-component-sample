# Symfony Routing Component Sample

Simplified sample of using Symfony Routing component.  
<br>
Assigning routes and their corresponding controllers.  
Handlers are specified as Closure callback and separate class of controller.

## Adding Routes and Processing Request with launch of Appropriate Controller
```php
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
    'messages_generate_url',
    new Route('messages/generate-url', ['_controller' => 'App\Controller\MessageController::generateUrl'])
);
$routes->add(
    'messages_item',
    new Route('messages/{id}', ['_controller' => 'App\Controller\MessageController::item'])
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
        case 'messages_generate_url': {
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
```
[Go To Sample](https://github.com/grn-it/symfony-routing-component-sample/blob/main/src/index.php)

## Controller with Simple Actions
```php
class MessageController
{
    /**
     * Route "/messages"
     */
    public function list(): string
    {
        return 'Messages list';
    }

    /**
     * Route "/messages/{id}"
     */
    public function item(int $id): string
    {
        return sprintf('Message item with id %d', $id);
    }

    /**
     * Route "/messages/generate-url"
     */
    public function generateUrl(UrlGenerator $generator): string
    {
        return sprintf(
            'Generated URL "%s"',
            $generator->generate('messages_item', ['id' => 123])
        );
    }
}
```
[Go To Sample](https://github.com/grn-it/symfony-routing-component-sample/blob/main/src/Controller/MessageController.php)

## Try-out
