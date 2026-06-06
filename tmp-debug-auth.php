<?php
require __DIR__ . '/vendor/autoload.php';
$app = require __DIR__ . '/bootstrap/app.php';
$app->make('config')->set('database.default', 'sqlite');
$app->make('config')->set('database.connections.sqlite.database', __DIR__ . '/database/database.sqlite');
$db = $app->make('db');
var_dump(get_class($app));
var_dump($db->connection()->getDatabaseName());
