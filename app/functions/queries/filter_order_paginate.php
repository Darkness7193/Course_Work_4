<?php

include_once(app_path().'/helpers/eloquent/filter.php');
include_once(app_path().'/helpers/eloquent/multi_order_by.php');
include_once(app_path().'/helpers/eloquent/paginate.php');


function filter_order_paginate($product_moves, $view_fields, $request) {
    filter($product_moves, $request->search_targets, $view_fields);
    multi_order_by($product_moves, $request->ordered_orders ?? [['created_at', 'asc']]);

    return paginate($product_moves,
        per_page: $request->session()->get('per_page') ?? 10,
        current_page: $request->current_page ?? 1,
    );
}
