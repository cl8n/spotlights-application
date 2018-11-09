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

$allFields = ['discord', 'mode'];
for ($i = 0; $i < sizeof($config['application']); $i++) {
    $allFields []= "q$i";
}
