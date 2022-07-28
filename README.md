# Symfony Routing Component Sample

<ins>Simplified</ins> sample of using standalone Symfony Routing component on Flat PHP Application.  
<br>
Assigning routes and their corresponding controllers.  
Handlers are specified as Closure callback and separate class of controller.

Run this command to fix permissions to be able to edit and create files:
```bash
docker-compose exec symfony-web-application make install uid=$(id -u)
```

## Adding Routes and Processing Request with Execute Appropriate Controller
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
```
[Go To Sample](https://github.com/grn-it/symfony-routing-component-sample/blob/main/src/index.php)

## Message Controller with Simple Actions
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

## Generator URL Controller
```php
class GeneratorUrlController
{
    /**
     * Route "/generator-url/messages-item"
     */
    public function messagesItem(UrlGenerator $generator): string
    {
        return sprintf(
            'Generated URL "%s"',
            $generator->generate('messages_item', ['id' => 123])
        );
    }
}

```

## Try-out
Request route "/"
```bash
curl http://127.0.0.1:8000
```

Response
```
index
```
---
Request route "/messages"
```bash
curl http://127.0.0.1:8000/messages
```

Response
```
Messages list
```
---
Request route "/messages/{id}"
```bash
curl http://127.0.0.1:8000/messages/123
```

Response
```
Message item with id 123
```
---
Request route "/generator-url/messages-item"
```bash
curl http://127.0.0.1:8000/generator-url/messages-item
```

Response
```
Generated URL "/messages/123"
```

## Resources
[Create your own PHP Framework](https://symfony.com/doc/current/create_framework/index.html)  
[Routing](https://symfony.com/doc/current/routing.html)  
[Symfony Routing Component](https://github.com/symfony/routing)
