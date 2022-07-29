<?php

namespace App\Controller;

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
