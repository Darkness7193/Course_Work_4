<?php


use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

function paginate(&$query, $per_page=null, $columns=['*'], $page_name = 'page', $current_page=1)
{
    $last_page = intdiv($query->count(), $per_page) + 1;
    $current_page = min($current_page, $last_page);

    return $query = $query->paginate($per_page, $columns, $page_name, $current_page);
}


function paginate_array(array &$items, $per_page=10, $current_page=1)
{
    $last_page = intdiv(count($items), $per_page) + 1;
    $current_page = min($current_page, $last_page);
    $page_content = Collection::make($items)->forPage($current_page, $per_page);

    return $items = new LengthAwarePaginator(
        $page_content, count($items), $per_page, $current_page);
}
