<?php

session_start();

$_SESSION['_state'] = random_bytes(64);
foreach ($allFields as $var) {
    if ($var[1] && empty($_POST[$var[0]])) {
        http_response_code(400);
        echo "Missing request parameter: $var[0]";
        exit;
    }

    if (preg_match('/q(\d+)/', $var[0], $matches) === 1
        && mb_strlen(str_replace("\r\n", "\n", $_POST[$var[0]])) > $questions[$matches[1]][1]) {
        http_response_code(400);
        echo "Request value is too large: $var[0]";
        exit;
    }

    $_SESSION[$var[0]] = $_POST[$var[0]];
}

$query = http_build_query([
    'response_type' => 'code',
    'scope' => 'identify',
    'client_id' => $config['osu']['client_id'],
    'redirect_uri' => $config['osu']['redirect_uri'],
    'state' => base64_encode($_SESSION['_state']),
]);

header("Location: https://osu.ppy.sh/oauth/authorize?$query");
