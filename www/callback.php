<?php

require_once __DIR__ . '/../constants.php';

if (empty($_GET['code'])) {
    http_response_code(403);
    echo 'User denied authorization';
    exit;
}

session_start();

if ($_SESSION['_state'] !== base64_decode($_GET['state'])) {
    http_response_code(403);
    echo 'Invalid CSRF-prevention token';
    exit;
}

$tokenRequestContext = stream_context_create([
    'http' => [
        'method' => 'POST',
        'content' => http_build_query([
            'grant_type' => 'authorization_code',
            'client_id' => $config['client_id'],
            'client_secret' => $config['client_secret'],
            'redirect_uri' => $config['redirect_uri'],
            'code' => $_GET['code'],
        ]),
    ],
]);
$tokenResponse = file_get_contents('https://osu.ppy.sh/oauth/token', false, $tokenRequestContext);
$token = json_decode($tokenResponse)->access_token;

$userRequestContext = stream_context_create([
    'http' => [
        'header' => "Authorization: Bearer $token\r\n",
    ],
]);
$userResponse = file_get_contents('https://osu.ppy.sh/api/v2/me', false, $userRequestContext);
$user = json_decode($userResponse);

$mode = $_SESSION['mode'];
$discord = $_SESSION['discord'];

$embedFields = array_map(function ($key, $value) {
    return [
        'name' => $value,
        'value' => $_SESSION[$key],
    ];
}, array_keys(FIELDS_QUESTIONS), array_values(FIELDS_QUESTIONS));

session_destroy();

if (substr($user->avatar_url, 0, 1) === '/') {
    $user->avatar_url = 'https://osu.ppy.sh' . $user->avatar_url;
}

$discordRequestContext = stream_context_create([
    'http' => [
        'method' => 'POST',
        'content' => json_encode([
            'avatar_url' => $user->avatar_url,
            'content' => "**[$user->username](https://osu.ppy.sh/users/$user->id)** applied to join the **$mode** Spotlights team! They can be contacted at @$discord.",
            'embeds' => [
                [
                    'color' => 0xff99cc,
                    'fields' => $embedFields,
                ],
            ],
        ]),
    ],
]);
file_get_contents($config['discord_webhook'], false, $discordRequestContext);

?>
<!DOCTYPE html>
<html>
<head>
</head>
<body>
    <p>Your application has been submitted!</p>
</body>
</html>
