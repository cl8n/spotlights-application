<?php

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

$tokenResponse = web_request('https://osu.ppy.sh/oauth/token', [
    'context' => [
        'method' => 'POST',
        'content' => http_build_query([
            'grant_type' => 'authorization_code',
            'client_id' => $config['osu']['client_id'],
            'client_secret' => $config['osu']['client_secret'],
            'redirect_uri' => $config['osu']['redirect_uri'],
            'code' => $_GET['code'],
        ]),
    ],
]);
$token = json_decode($tokenResponse)->access_token;

$userResponse = web_request('https://osu.ppy.sh/api/v2/me', [
    'auth' => 'osu',
], [
    'token' => $token,
]);
$user = json_decode($userResponse);

$mode = $_SESSION['mode'];
$discord = $_SESSION['discord'];

$trelloDescription = "osu!: https://osu.ppy.sh/users/$user->id\nMode: $mode\nDiscord: @$discord";
for ($i = 0; $i < sizeof($config['application']); $i++) {
    $trelloDescription .= "\n\n**{$config['application'][$i]}**\n{$_SESSION["q$i"]}";
}

session_destroy();

$cardResponse = web_request('https://api.trello.com/1/cards', [
    'auth' => 'trello',
    'context' => [
        'method' => 'POST',
    ],
    'query' => [
        'name' => $user->username,
        'desc' => $trelloDescription,
        'idList' => $config['trello']['list'],
        'idMembers' => $config['trello']['members'],
        'idLabels' => $config['trello']['labels'],
    ],
]);
$card = json_decode($cardResponse);

$checklistResponse = web_request('https://api.trello.com/1/checklists', [
    'auth' => 'trello',
    'context' => [
        'method' => 'POST',
    ],
    'query' => [
        'idCard' => $card->id,
        'name' => 'Verification',
    ],
]);
$checklistId = json_decode($checklistResponse)->id;

web_request("https://api.trello.com/1/checklists/$checklistId/checkItems", [
    'auth' => 'trello',
    'context' => [
        'method' => 'POST',
    ],
    'query' => [
        'name' => 'Verified',
    ],
]);

if (substr($user->avatar_url, 0, 1) === '/') {
    $user->avatar_url = 'https://osu.ppy.sh' . $user->avatar_url;
}

web_request($config['discord']['webhook'], [
    'context' => [
        'method' => 'POST',
        'content' => json_encode([
            'embeds' => [[
                'color' => 0xff99cc,
                'title' => "$user->username submitted an application!",
                'url' => $card->url,
                'thumbnail' => ['url' => $user->avatar_url],
                'description' => "Application: $card->url\nosu!: https://osu.ppy.sh/users/$user->id\nMode: $mode\nDiscord: @$discord",
            ]],
        ]),
    ],
]);

header('Location: /submitted');
