<?php


function get_columns($array) {
    $columns = [];
    foreach ($array as $row) {
        foreach ($row as $i => $value) {
            $columns[$i][] = $value;
        }
    }

    return $columns;
}
