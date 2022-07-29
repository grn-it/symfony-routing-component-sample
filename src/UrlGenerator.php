<?php

use Symfony\Component\Routing\Generator\UrlGenerator;

require_once __DIR__.'/../vendor/autoload.php';
require_once __DIR__.'/Routes.php';

$generator = new UrlGenerator($routes, $context);
echo json_encode(['url' => $generator->generate('messages_item', ['id' => 48])]);
