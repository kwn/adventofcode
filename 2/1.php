<?php

$content = file_get_contents(__DIR__ . '/values.txt');
$removeEmptyStrings = static fn(string $value): string => $value !== '';

$values = array_filter(explode(PHP_EOL, $content), $removeEmptyStrings);
$values = array_map(static function (string $value) {
    preg_match('/(?<min>\d+)-(?<max>\d+) (?<letter>[a-z]): (?<password>.+)/', $value, $matches);

    return [
        'min' => (int) $matches['min'],
        'max' => (int) $matches['max'],
        'letter' => $matches['letter'],
        'password' => $matches['password']
    ];
}, $values);

$between = static fn(int $min, int $max, int $number): bool => $min <= $number && $number <= $max;
$valid = static fn(array $line): bool => $between($line['min'], $line['max'], substr_count($line['password'], $line['letter']));

echo count(array_filter($values, $valid));
