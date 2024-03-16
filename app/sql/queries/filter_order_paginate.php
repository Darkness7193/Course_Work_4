<?php

include_once(app_path().'/sql/queries/filter.php');
include_once(app_path().'/sql/helpers/multi_order_by.php');
include_once(app_path().'/sql/helpers/paginate.php');




function filter_order_paginate($product_moves, $view_fields, $request, $default_order) {
    if ($product_moves === null) { $arr=[]; return paginate_array($arr, 1); }
    filter($product_moves, $request->search_targets, $view_fields);
    multi_order_by($product_moves, $request->ordered_orders ?? [$default_order]);

    return paginate($product_moves,
        per_page: session()->get('per_page') ?? 10,
        current_page: $request->current_page ?? 1,
    );
}
