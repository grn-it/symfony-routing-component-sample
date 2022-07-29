# Symfony Routing Component Sample

<ins>Simplified</ins> sample of using standalone Symfony Routing component on Flat PHP Application.  
<br>
Assigning routes and their corresponding controllers.  
Handlers are specified as Closure callback and separate class of controller.

Run this command to fix permissions to be able to edit and create files:
```bash
docker-compose exec symfony-web-application make install uid=$(id -u)
```

## Routes
```php
$context = new RequestContext();
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
```
[Go To Sample](https://github.com/grn-it/symfony-routing-component-sample/blob/main/src/Routes.php)

## Request Processing
```php
$matcher = new UrlMatcher($routes, $context);
$parameters = $matcher->match($_SERVER['REQUEST_URI']);

if ($parameters['_controller'] instanceof \Closure) {
    echo $parameters['_controller']();
} else {
    $callable = explode('::', $parameters['_controller']);
    $object = new $callable[0]();
    $method = $callable[1];
    
    switch ($parameters['_route']) {
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

## Controller
```php
class MessageController
{
    /**
     * Route "/messages"
     */
    public function list(): string
    {
        $messages = [
            [
                'id' => 46,
                'from' => [
                    'id' => 55,
                    'email' => 'walter@gmail.com'
                ],
                'to' => [
                    'id' => 56,
                    'email' => 'kate@gmail.com'
                ],
                'text' => 'Hi, Kate, how are you settling in?',
                'createdAt' => '2022-07-03 12:14:53'
            ],
            [
                'id' => 47,
                'from' => [
                    'id' => 56,
                    'email' => 'kate@gmail.com'
                ],
                'to' => [
                    'id' => 55,
                    'email' => 'walter@gmail.com'
                ],
                'text' => 'Just fine thanks. I appreciate you taking the time to help me out with this software. May I ask you what we will be covering today?',
                'createdAt' => '2022-07-03 12:15:05'
            ],
            [
                'id' => 48,
                'from' => [
                    'id' => 55,
                    'email' => 'walter@gmail.com'
                ],
                'to' => [
                    'id' => 56,
                    'email' => 'kate@gmail.com'
                ],
                'text' => 'Sure. Before I do that, could you tell me if you\'ve worked with this program before? That will help me figure out how to proceed',
                'createdAt' => '2022-07-03 12:15:17'
            ]
        ];
        
        return json_encode($messages);
    }

    /**
     * Route "/messages/{id}"
     */
    public function item(int $id): string
    {
        $message = [
            'id' => 48,
            'from' => [
                'id' => 55,
                'email' => 'walter@gmail.com'
            ],
            'to' => [
                'id' => 56,
                'email' => 'kate@gmail.com'
            ],
            'text' => 'Sure. Before I do that, could you tell me if you\'ve worked with this program before? That will help me figure out how to proceed',
            'createdAt' => '2022-07-03 12:15:17'
        ];
        
        return json_encode($message);
    }
}
```
[Go To Sample](https://github.com/grn-it/symfony-routing-component-sample/blob/main/src/Controller/MessageController.php)

## URL Generator
```php
$generator = new UrlGenerator($routes, $context);
echo json_encode(['url' => $generator->generate('messages_item', ['id' => 48])]);
```
[Go To Sample](https://github.com/grn-it/symfony-routing-component-sample/blob/main/src/UrlGenerator.php)

## Try-out
Request route `"/"`
```bash
curl http://127.0.0.1:8000
```

Response
```json
{"message":"Hello. This is index page"}
```
<br>

Request route `"/messages"`
```bash
curl http://127.0.0.1:8000/messages
```

Response
```json
[
  {
    "id": 46,
    "from": {
      "id": 55,
      "email": "walter@gmail.com"
    },
    "to": {
      "id": 56,
      "email": "kate@gmail.com"
    },
    "text": "Hi, Kate, how are you settling in?",
    "createdAt": "2022-07-03 12:14:53"
  },
  {
    "id": 47,
    "from": {
      "id": 56,
      "email": "kate@gmail.com"
    },
    "to": {
      "id": 55,
      "email": "walter@gmail.com"
    },
    "text": "Just fine thanks. I appreciate you taking the time to help me out with this software. May I ask you what we will be covering today?",
    "createdAt": "2022-07-03 12:15:05"
  },
  {
    "id": 48,
    "from": {
      "id": 55,
      "email": "walter@gmail.com"
    },
    "to": {
      "id": 56,
      "email": "kate@gmail.com"
    },
    "text": "Sure. Before I do that, could you tell me if you've worked with this program before? That will help me figure out how to proceed",
    "createdAt": "2022-07-03 12:15:17"
  }
]
```
<br>

Request route `"/messages/{id}"`
```bash
curl http://127.0.0.1:8000/messages/48
```

Response
```json
{
  "id": 48,
  "from": {
    "id": 55,
    "email": "walter@gmail.com"
  },
  "to": {
    "id": 56,
    "email": "kate@gmail.com"
  },
  "text": "Sure. Before I do that, could you tell me if you've worked with this program before? That will help me figure out how to proceed",
  "createdAt": "2022-07-03 12:15:17"
}

```
<br>

Execute URL Generator
```bash
php src/UrlGenerator.php
```

Output
```json
{"url":"/messages/48"}
```

## Resources
[Create your own PHP Framework](https://symfony.com/doc/current/create_framework/index.html)  
[Routing](https://symfony.com/doc/current/routing.html)  
[Symfony Routing Component](https://github.com/symfony/routing)
