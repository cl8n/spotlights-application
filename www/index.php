<?php

require_once __DIR__ . '/../include.php';

$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

switch ($path) {
    case '':
    case '/':
    case '/index.php':
        require __DIR__ . '/../pages/index.php';
        break;

    case '/submit':
        require __DIR__ . '/../pages/application.php';
        break;

    case '/callback':
        require __DIR__ . '/../pages/callback.php';
        break;

    case '/submitted':
        require __DIR__ . '/../pages/submitted.php';
        break;
}
