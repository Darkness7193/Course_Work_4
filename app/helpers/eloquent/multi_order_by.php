<?php


function multi_order_by(&$rows, $orders)
{
    if ($orders === []) { return $rows; }
    foreach ($orders as [$field, $direction]) {
        $rows = $rows->orderBy($field, $direction);
    }

    return $rows;
}

