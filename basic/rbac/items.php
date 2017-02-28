<?php
return [
    'usercontrol' => [
        'type' => 2,
        'description' => 'Control Users',
    ],
    'admin' => [
        'type' => 1,
        'children' => [
            'usercontrol',
        ],
    ],
];
