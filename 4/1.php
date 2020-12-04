<?php

$lines = explode(PHP_EOL, file_get_contents(__DIR__ . '/passports.txt'));

$passports = array_reduce($lines, static function(array $acc, string $line) {
    if ($line !== '') {
        $fields = array_pop($acc);

        return [...$acc, trim($fields . ' ' . $line)];
    }

    return [...$acc, ''];
}, ['']);

$mandatoryFields = ['byr:', 'iyr:', 'eyr:', 'hgt:', 'hcl:', 'ecl:', 'pid:'];

$isValid = static fn(string $passport) => count(array_filter($mandatoryFields, static fn(string $field) => strpos($passport, $field) === false)) === 0;

$validPassports = array_filter($passports, $isValid);

echo count($validPassports);
