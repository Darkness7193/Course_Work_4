<?php

include_once(app_path().'/helpers/where_some_field_like.php');
include_once(app_path().'/helpers/paginate.php');


function filter_order_paginate($product_moves, $request) {
    where_some_field_like($product_moves, $request->search_target)
        ->orderBy('created_at');

    paginate($product_moves,
        per_page: $request->session()->get('per_page') ?? 10,
        current_page: $request->current_page ?? 1,
    );

    return $product_moves;
}
