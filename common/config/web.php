<?php
return [
    'components' => [
        'request' => [
            'cookieValidationKey' => 'your-secure-key-here',
            'csrfParam' => '_csrf-app',
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-app', 'httpOnly' => true],
        ],
        'session' => [
            'name' => 'app-session',
        ],
    ],
];
