<?php
function  build_sorter_arr_obj($key) {
    return function ($a, $b) use ($key) {
        return strnatcmp($a->$key, $b->$key);
    };
}