<?php

$secret = "mysecret123";

if (!isset($_GET['key']) || $_GET['key'] !== $secret) {
    die("Unauthorized");
}

// SESUAIKAN DENGAN STRUKTUR KAMU
require __DIR__ . '/../kelurahan-cms/vendor/autoload.php';
$app = require_once __DIR__ . '/../kelurahan-cms/bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);

$commands = [
    'storage:link',
    'config:clear',
    'cache:clear',
    'view:clear',
    'route:clear',
    'optimize:clear'
];

foreach ($commands as $command) {
    echo "Running: $command<br>";
    $kernel->call($command);
    echo nl2br($kernel->output()) . "<br><hr>";
}

echo "DONE";
