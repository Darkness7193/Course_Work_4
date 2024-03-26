<?php




function multi_order_by(&$query, $orders)
{
    if ($orders === []) { return $query; }
    foreach ($orders as [$field, $direction]) {$query=$query
        ->orderBy($field, $direction);
    }

    return $query;
}

