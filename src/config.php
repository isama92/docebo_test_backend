<?php

// returns directly the configuration so it can be imported into a variable

return [
    'db' => [
        'hostname' => 'dbe_mysql',
        'username' => 'root',
        'password' => 'password',
        'database' => 'docebo',
    ],
    'api' => [
        'default_page_num' => 0,
        'default_page_size' => 100,
    ],
];
