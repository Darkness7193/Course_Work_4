<?php

include_once(app_path().'/helpers/where_some_field_like.php');
include_once(app_path().'/helpers/paginate.php');


function filter($rows, $search_targets, $view_fields) {
    if (empty($search_targets)) { return $rows; }

    $rows = where_some_field_like($rows, $search_targets['tablewise'] ?? null, $view_fields);
    unset($search_targets['tablewise']);

    foreach ($search_targets as $target_field => $search_target) {
        $rows = where_field_like($rows, $search_target, $target_field);
    }

    return $rows;
}


function filter_order_paginate($product_moves, $view_fields, $request) {
    filter($product_moves, $request->search_targets, $view_fields)
        ->orderBy('created_at');

    return paginate($product_moves,
        per_page: $request->session()->get('per_page') ?? 10,
        current_page: $request->current_page ?? 1,
    );
}
