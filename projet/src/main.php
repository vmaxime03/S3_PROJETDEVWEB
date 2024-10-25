<?php
declare(strict_types=1);

require __DIR__ . '/../vendor/autoload.php';

session_start();

use iutnc\deefy\db\DeefyRepository;
use iutnc\deefy\dispatch\Dispatcher;

DeefyRepository::setConfig(__DIR__ . '/../config/deefy.db.ini');

$dispatcher = new Dispatcher();

$dispatcher->run();



