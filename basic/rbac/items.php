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
    'admin' => [
        'type' => 1,
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
