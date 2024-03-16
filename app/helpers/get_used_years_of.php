<?php

use App\Models\ProductMove;




function get_used_years_of($report_storage_id) {
    $years = [];
    if ($report_storage_id) {
        $product_moves = ProductMove
            ::where('storage_id', '=', $report_storage_id)
            ->orWhere('new_storage_id', '=', $report_storage_id)
            ->get();

        foreach ($product_moves as $product_move) {
            $years[] = $product_move->date->year;
        }
    }

    $years = array_values(array_unique($years));
    rsort($years);
    return $years;
}
