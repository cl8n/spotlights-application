<?php

session_start();

$_SESSION['_state'] = random_bytes(64);
foreach ($allFields as $var) {
    if (empty($_POST[$var])) {
        http_response_code(400);
        echo "Missing request parameter: $var";
        exit;
    }

    $_SESSION[$var] = $_POST[$var];
}

$query = http_build_query([
    'response_type' => 'code',
    'scope' => '',
    'client_id' => $config['osu']['client_id'],
    'redirect_uri' => $config['osu']['redirect_uri'],
    'state' => base64_encode($_SESSION['_state']),
]);

header("Location: https://osu.ppy.sh/oauth/authorize?$query");
