<?php

$content = file_get_contents(__DIR__ . '/values.txt');
$removeEmptyStrings = static fn(string $value): string => $value !== '';
$castToInt = static fn(string $value): int => (int) $value;

$values = array_filter(explode(PHP_EOL, $content), $removeEmptyStrings);
$values = array_map($castToInt, $values);

foreach ($values as $value1) {
    $needle = 2020 - $value1;

    foreach ($values as $value2) {
        $leftover = $needle - $value2;

        if (in_array($leftover, $values, true)) {
            echo $value1 * $value2 * $leftover;
            return;
        }
    }
}
