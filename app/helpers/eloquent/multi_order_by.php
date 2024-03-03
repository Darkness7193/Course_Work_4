<?php


function multi_order_by(&$rows, $orders)
{
    foreach ($orders as $field_name) {
        $rows = $rows->orderBy($field_name);
    }

    return $rows;
}
