<?php

use \PommProject\Foundation\Pomm;

$loader = require __DIR__.'/vendor/autoload.php';
$loader->add(null, __DIR__);

return new Pomm(['booking' =>
    [
        'dsn' => 'pgsql://user:pass@host:port/db_name',
        'class:session_builder' => '\PommProject\ModelManager\SessionBuilder',
    ]
]);