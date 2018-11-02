<?php

const APPLICATION_PARTS = [
    'discord',
    'mode',
    'q1',
    'q2',
    'q3',
    'q4',
    'q5',
];

if ($_SERVER['REQUEST_METHOD'] !== 'POST'
    || !empty(array_diff(APPLICATION_PARTS, array_keys($_POST)))) {
    http_response_code(400);
    echo 'Invalid request';
    exit;
}

$config = require __DIR__ . '/../config.php';
session_start();

$_SESSION['_state'] = random_bytes(64);
foreach (APPLICATION_PARTS as $var) {
    $_SESSION[$var] = $_POST[$var];
}

$query = http_build_query([
    'response_type' => 'code',
    'scope' => '',
    'client_id' => $config['client_id'],
    'redirect_uri' => $config['redirect_uri'],
    'state' => base64_encode($_SESSION['_state']),
]);

header("Location: https://osu.ppy.sh/oauth/authorize?$query");
