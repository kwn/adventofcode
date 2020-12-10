<?php

$passes = explode(PHP_EOL, file_get_contents(__DIR__ . '/boarding.txt'));

$halfOf = static fn(int $hi, int $lo): int => ceil(($hi - $lo) / 2);

$reducer = static fn(array $acc, string $char): array => $char === 'F' || $char === 'L'
    ? [$acc[0], $acc[1] - $halfOf($acc[1], $acc[0])]
    : [$acc[0] + $halfOf($acc[1], $acc[0]), $acc[1]];

$decoder = static fn(string $pass): int => 8
    * array_reduce(str_split(substr($pass, 0, 7)), $reducer, [0, 127])[0]
    + array_reduce(str_split(substr($pass, 7, 3)), $reducer, [0, 7])[0];

echo max(array_map($decoder, $passes));
