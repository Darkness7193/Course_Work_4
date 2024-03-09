<?php


use App\Models\ProductMove;

function get_used_years($storage_id_of_report) {
    $years = [];
    $product_moves = ProductMove
        ::where('storage_id', '=', $storage_id_of_report)
        ->orWhere('new_storage_id', '=', $storage_id_of_report)
        ->get();

    foreach ($product_moves as $product_move) {
        $years[] = $product_move->date->year;
    }

    $years = array_values(array_unique($years));
    rsort($years);
    return $years;
}
