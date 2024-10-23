<?php
declare(strict_types=1);

require __DIR__ . '/../vendor/autoload.php';

session_start();

use iutnc\deefy\dispatch\Dispatcher;


$dispatcher = new Dispatcher();

$dispatcher->run();
