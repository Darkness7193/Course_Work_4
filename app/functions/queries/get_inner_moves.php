<?php


function get_inner_moves($product_moves) {
    return $product_moves->where( function($query) {
        $query->orWhere('product_move_type', 'liquidating')
            ->orWhere('product_move_type', 'inventory')
            ->orWhere('product_move_type', 'transfering');
    });
}
