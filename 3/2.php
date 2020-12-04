<?php

$lines = explode(PHP_EOL, file_get_contents(__DIR__ . '/input.txt'));

$nextPosition = static fn(int $current, int $increment, string $line): int => ($current + $increment) % strlen($line);
$treesIncrement = static fn(int $position, string $line, int $trees): int => $line[$position] === '#' ? ++$trees : $trees;

$reducer = static fn(array $acc, string $line): array => [
    'position' => $nextPosition($acc['position'], $acc['increment'], $line),
    'increment' => $acc['increment'],
    'trees' => $treesIncrement($acc['position'], $line, $acc['trees'])
];

$mapGenerator = static fn(array $lines, int $skipEvery): array => array_filter($lines, static fn(string $line, int $index) => $index % $skipEvery === 0, ARRAY_FILTER_USE_BOTH);
$treesCounter = static fn(int $right, int $down): int => array_reduce($mapGenerator($lines, $down), $reducer, ['position' => 0, 'increment' => $right, 'trees' => 0])['trees'];

$slopes = [
    ['r' => 1, 'd' => 1],
    ['r' => 3, 'd' => 1],
    ['r' => 5, 'd' => 1],
    ['r' => 7, 'd' => 1],
    ['r' => 1, 'd' => 2],
];

$trees = array_reduce($slopes, static fn(int $acc, array $slope): int => $acc * $treesCounter($slope['r'], $slope['d']), 1);

echo $trees;