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
    'Why do you want to join the Spotlights Team?',
    'How would you be able to further assist the Spotlights Team?',
    'Do you have any mapping or modding experience? How much?',
    'Select three beatmaps you think are worthy of spotlight and explain why (Ranked maps only).'
];

$limits = [
    500,
    500,
    550,
    2000
];

$allFields = ['discord', 'mode'];
for ($i = 0; $i < count($questions); $i++) {
    $allFields []= "q$i";
}

