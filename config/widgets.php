<?php

return [
    'accordion' => [
        'published' => true,
        'class' => '\TailorSheet_Manager\Widgets\Accordion'
    ],
    'appsheet_functions_examples' => [
        'published' => true,
        'class' => '\TailorSheet_Manager\Widgets\AppSheet_Functions_Examples'
    ],
    'appsheet_functions_explanation' => [
        'published' => true,
        'class' => '\TailorSheet_Manager\Widgets\AppSheet_Functions_Explanation'
    ],
    'post_list' => [
        'published' => true,
        'class' => '\TailorSheet_Manager\Widgets\Post_List',
        'dependencies' => [
            'css' => [
                'file' => 'post-list.css',
                'type' => 'css',
                'version' => '1.0.0',
            ],
            'js' => [
                'file' => 'post-list.js',
                'type' => 'js',
                'version' => '1.0.0',
            ],
            'alpinejs' => [
                'file' => 'alpine.min.js',
                'type' => 'js',
                'version' => '3.14.1',
            ],
        ]
    ]
];