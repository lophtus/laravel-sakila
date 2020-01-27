<?php

require(__DIR__ . '/../vendor/autoload.php');

$openApi = \OpenApi\scan(
    __DIR__ . '/../',
    ['exclude' => [
        'vendor'
    ]]
);

header('Content-Type: application/json');

echo $openApi->toJson();
