<?php

$lines = explode(PHP_EOL, file_get_contents(__DIR__ . '/passports.txt'));

$passports = array_reduce($lines, static function(array $acc, string $line): array {
    if ($line !== '') {
        $passport = array_pop($acc);

        $fields = array_reduce(explode(' ', $line), static function (array $acc, string $field): array {
            $kv = explode(':', $field);
            $acc[$kv[0]] = $kv[1];

            return $acc;
        }, []);

        return [...$acc, array_merge($passport, $fields)];
    }

    return [...$acc, []];
}, [[]]);

$yearBetween = static fn(string $from, string $to, string $value): bool => preg_match('/^\d{4}$/', $value) === 1 && $from <= (int) $value && (int) $value <= $to;

$byr = static fn(string $value): bool => $yearBetween(1920, 2002, $value);
$iyr = static fn(string $value): bool => $yearBetween(2010, 2020, $value);
$eyr = static fn(string $value): bool => $yearBetween(2020, 2030, $value);
$hgt = static function(string $value): bool {
    $res = preg_match('/^(?<value>\d{2,3})(?<unit>cm|in)$/', $value, $matches);
    $validCm = static fn(string $unit, string $value) => $unit === 'cm' && 150 <= (int) $value && (int) $value <= 193;
    $validIn = static fn(string $unit, string $value) => $unit === 'in' && 59 <= (int) $value && (int) $value <= 76;
    return $res === 1 && ($validCm($matches['unit'], $matches['value']) xor $validIn($matches['unit'], $matches['value']));
};
$hcl = static fn(string $value): bool => preg_match('/^#[0-9a-f]{6}$/', $value) === 1;
$ecl = static fn(string $value): bool => preg_match('/^amb|blu|brn|gry|grn|hzl|oth$/', $value) === 1;
$pid = static fn(string $value): bool => preg_match('/^\d{9}$/', $value) === 1;

$isValid = static fn(array $p): bool => $byr($p['byr'] ?? '')
    && $iyr($p['iyr'] ?? '')
    && $eyr($p['eyr'] ?? '')
    && $hgt($p['hgt'] ?? '')
    && $hcl($p['hcl'] ?? '')
    && $ecl($p['ecl'] ?? '')
    && $pid($p['pid'] ?? '');

$validPassports = array_filter($passports, $isValid);

echo count($validPassports);
