<?php

const FIELDS_INFO = [
    'discord' => null,
    'mode' => null,
];

const FIELDS_QUESTIONS = [
    'q1' => 'How long have you been playing the game for?',
    'q2' => 'Why do you want to join this team? What do you wish to do here?',
    'q3' => 'Do you have any experience selecting maps for other projects or community tournaments? If so, which ones?',
    'q4' => 'What kind of other experience do you have in the game (mapping, modding, playing regularly)?',
    'q5' => 'Select your 5 favourite beatmap and explain to us briefly why did you choose those.',
];

$allFields = array_merge(FIELDS_INFO, FIELDS_QUESTIONS);

$config = require __DIR__ . '/config.php';
