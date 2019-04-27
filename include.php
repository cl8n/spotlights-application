<?php

$config = require __DIR__ . '/config.php';

function web_request($url, $options, $params = []) {
    global $config;

    $contextOptions = [];
    $query = '';

    if (!empty($options['context'])) {
        $contextOptions = $options['context'];
    }

    if (!empty($options['query'])) {
        $query = '?' . http_build_query($options['query']);
    }

    $contextOptions['header'] = "Content-Type: application/x-www-form-urlencoded\r\n";

    if (!empty($options['auth'])) {
        switch ($options['auth']) {
            case 'trello':
                $query .= '&' . http_build_query([
                    'key' => $config['trello']['api_key'],
                    'token' => $config['trello']['auth_token'],
                ]);
                break;
            case 'osu':
                $contextOptions['header'] .= "Authorization: Bearer {$params['token']}\r\n";
                break;
        }
    }

    return file_get_contents(
        $url . $query,
        false,
        stream_context_create(['http' => $contextOptions])
    );
}

$questions = [
    ['Do you have any mapping or modding experience? How much?', 200, true],
    ['Select three Ranked beatmaps that you think would be worthy for Spotlights, and for each one, explain why.', 2000, true],
    ['Are there any other ways that you would like to assist the osu! Spotlights Team beyond selecting maps?', 500, false],
];

$allFields = [
    ['discord', true],
    ['mode', true],
];
for ($i = 0; $i < count($questions); $i++) {
    $allFields []= ["q$i", $questions[$i][2]];
}
