<?php

namespace App\Controller;

use Symfony\Component\Routing\Generator\UrlGenerator;

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
