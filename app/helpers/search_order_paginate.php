<?php


function search_order_paginate($product_moves, $request) {
    multi_fields_search($product_moves, $request->search_target)->
    orderBy('date');
    paginate($product_moves,
        per_page: $request->session()->get('per_page') ?? 10,
        current_page: $request->current_page ?? 1,
    );

    return $product_moves;
}
