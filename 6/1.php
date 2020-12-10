<?php

$lines = explode(PHP_EOL, file_get_contents(__DIR__ . '/input.txt'));

$answers = array_reduce($lines, static function(array $acc, string $line) {
    if ($line !== '') {
        $questions = array_pop($acc);

        return [...$acc, trim($questions . $line)];
    }

    return [...$acc, ''];
}, ['']);

$map = array_map(static fn(string $answer): int => count(array_unique(str_split($answer))), $answers);

echo array_sum($map);
