<?php


function paginate(&$query, $per_page=null, $columns=['*'], $page_name = 'page', $current_page=null)
{
    $test_paginator = $query->paginate($per_page, ['id'], $page_name, $current_page);

    $current_page = min($test_paginator->currentPage(), $test_paginator->lastPage());

    return $query = $query->paginate($per_page, $columns, $page_name, $current_page);
}
