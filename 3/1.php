<?php

$lines = explode(PHP_EOL, file_get_contents(__DIR__ . '/input.txt'));

$nextPosition = static fn(int $current, string $line): int => ($current + 3) % strlen($line);
$treesIncrement = static fn(int $position, string $line, int $trees): int => $line[$position] === '#' ? ++$trees : $trees;

$reducer = static fn(array $acc, string $line): array => [
    'position' => $nextPosition($acc['position'], $line),
    'trees' => $treesIncrement($acc['position'], $line, $acc['trees'])
];

$value = array_reduce($lines, $reducer, ['position' => 0, 'trees' => 0]);

echo $value['trees'];