<?php

/**
 * Check if batch
 *
 * @param  array $data
 * @return bool
 */
function isBatch($data): bool
{
    return count($data) > 1;
}

/**
 * Is Equal
 *
 * @param  string $string
 * @param  string $comparator
 * @return bool
 */
function isEqual(string $string, string $comparator): bool
{
    return strtolower($string) === strtolower($comparator);
}

/**
 * Convert stdClass to Array
 *
 * @param  mixed $data
 * @return array
 */
function toArray(mixed $data): array
{
    return json_decode(json_encode($data), true);
}

/**
 * Var Dump
 *
 * @param  $data
 * @return void
 */
function dd($data): void
{
    highlight_string("" . var_export($data, true) . "");
    die();
}
