<?php

include_once(app_path().'/helpers/eloquent/where_field_like.php');
include_once(app_path().'/helpers/eloquent/where_some_field_like.php');
include_once(app_path().'/helpers/eloquent/filter.php');
include_once(app_path().'/helpers/eloquent/paginate.php');


function filter_order_paginate($product_moves, $view_fields, $request) {
    filter($product_moves, $request->search_targets, $view_fields)
        ->orderBy('created_at');

    return paginate($product_moves,
        per_page: $request->session()->get('per_page') ?? 10,
        current_page: $request->current_page ?? 1,
    );
}
