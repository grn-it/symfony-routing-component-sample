<?php

namespace App\Controller;

use Symfony\Component\Routing\Generator\UrlGenerator;

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
}
