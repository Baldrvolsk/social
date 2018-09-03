<?php
defined('BASEPATH') OR exit('No direct script access allowed');

function build_sorter_arr_obj($key) {
    return function ($a, $b) use ($key) {
        return strnatcmp($a->$key, $b->$key);
    };
}

/**
 * @param array $arr
 *
 * @return bool Return true if assoc array
 */
function isAssoc(array $arr) {
    if (array() === $arr) return false;
    return array_keys($arr) !== range(0, count($arr) - 1);
}