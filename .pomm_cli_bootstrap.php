<?php

use \PommProject\Foundation\Pomm;

$loader = require __DIR__.'/vendor/autoload.php';
$loader->add(null, __DIR__);

return new Pomm(['booking' =>
    [
        'dsn' => 'pgsql://postgres:coldshadow@127.0.0.1:5432/booking',
        'class:session_builder' => '\PommProject\ModelManager\SessionBuilder',
    ]
]);