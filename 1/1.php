<?php

$content = file_get_contents(__DIR__ . '/values.txt');
$removeEmptyStrings = static fn(string $value): string => $value !== '';
$castToInt = static fn(string $value): int => (int) $value;

$values = array_filter(explode(PHP_EOL, $content), $removeEmptyStrings);
$values = array_map($castToInt, $values);

foreach ($values as $value) {
    $needle = 2020 - $value;

    if (in_array($needle, $values, true)) {
        echo $needle * $value;
        return;
    }
}
