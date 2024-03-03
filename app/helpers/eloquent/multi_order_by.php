<?php


function multi_order_by(&$rows, $orders)
{
    foreach ($orders as $field_name => $direction) {
        $rows = $rows->orderBy($field_name, $direction);
    }

    return $rows;
}
