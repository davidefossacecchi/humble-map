<?php
namespace Dfossacecchi\HumbleMap;


function from_pascal_to_snakecase($word) {
    $parts = preg_split('/(?=\p{Lu}{1})/u', $word, 0, PREG_SPLIT_DELIM_CAPTURE | PREG_SPLIT_NO_EMPTY);
    $lc    = array_map( function($part) {
        return strtolower($part);
    }, $parts);
    return implode('_', $lc);
}
