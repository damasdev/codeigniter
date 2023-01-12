<?php

/**
 * Is Equal.
 *
 * @param string $string
 * @param string $comparator
 *
 * @return bool
 */
function isEqual(string $string, string $comparator): bool
{
    return strtolower($string) === strtolower($comparator);
}

/**
 * Convert stdClass to Array.
 *
 * @param $data
 *
 * @return array
 */
function toArray($data): array
{
    return json_decode(json_encode($data), true);
}

/**
 * Var Dump.
 *
 * @param $data
 *
 * @return void
 */
function dd($data): void
{
    highlight_string(''.var_export($data, true).'');
    exit();
}

/**
 * User
 *
 * @return ?stdClass
 */
function user(): ?stdClass
{
    $ci =&get_instance();
    $ci->load->library('session');

    return $ci->session->userdata('user');
}