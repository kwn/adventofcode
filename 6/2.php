<?php

$lines = explode(PHP_EOL, file_get_contents(__DIR__ . '/input.txt'));

$answers = array_reduce($lines, static function(array $acc, string $line): array {
    if ($line !== '') {
        $passport = array_pop($acc);
        $passport[] = str_split($line);

        return [...$acc, $passport];
    }

    return [...$acc, []];
}, [[]]);

$map = array_map(static fn(array $answer): int => count(count($answer) > 1 ? array_intersect(...$answer) : reset($answer)), $answers);

echo array_sum($map);