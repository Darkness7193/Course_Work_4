<?php


use App\Models\ProductMove;

function get_used_years($storage_id_of_report) {
    $years = [];
    foreach (ProductMove::where('storage_id', '=', $storage_id_of_report)->get() as $product_move) {
        $years[] = $product_move->date->year;
    }
    $years = array_values(array_unique($years));
    rsort($years);

    return $years;
}
