<?php


function paginate(&$query, $per_page=null, $columns=['*'], $page_name = 'page', $current_page=null)
{
    $last_page = intdiv($query->count(), $per_page) + 1;
    $current_page = min($current_page ?? 1, $last_page);

    return $query = $query->paginate($per_page, $columns, $page_name, $current_page);
}
