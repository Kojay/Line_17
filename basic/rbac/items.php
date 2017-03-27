<?php
return [
    'usercontrol' => [
        'type' => 2,
        'description' => 'Control Users',
    ],
    'all' => [
        'type' => 2,
        'description' => 'Control all things',
    ],
    'user' => [
        'type' => 1,
        'description' => 'Standard User',
    ],
    'admin' => [
        'type' => 1,
        'description' => 'Control administrative things',
        'children' => [
            'usercontrol',
        ],
    ],
    'supervisor' => [
        'type' => 1,
        'children' => [
            'usercontrol',
            'all'
        ],
    ],
];
