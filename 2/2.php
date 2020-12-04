<?php

$values = explode(PHP_EOL,file_get_contents(__DIR__ . '/values.txt'));

$values = array_map(static function (string $value) {
    preg_match('/(?<first>\d+)-(?<second>\d+) (?<letter>[a-z]): (?<password>.+)/', $value, $matches);

    return [
        'first' => (int) $matches['first'],
        'second' => (int) $matches['second'],
        'letter' => $matches['letter'],
        'password' => $matches['password']
    ];
}, $values);

$valid = static fn(array $line): bool => $line['password'][--$line['first']] === $line['letter'] xor $line['password'][--$line['second']] === $line['letter'];

echo count(array_filter($values, $valid));
