<?php

include_once(app_path().'/sql/queries/report_totals/quantity_totals.php');
include_once(app_path().'/sql/queries/report_totals/move_type_totals.php');

use App\Models\ProductMove;
use function App\sql\queries\move_type_totals\move_type_totals;




function product_totals($report_options) {
    [$current_report_type, $report_storage, $report_year, $is_cost_report] = array_values($report_options);

    if (in_array($current_report_type, ProductMove::product_move_types())) {
        return move_type_totals($current_report_type, $report_storage->id, $report_year, $is_cost_report);
    } else if ($current_report_type === 'quantities') {
        return quantity_totals($report_storage->id, $report_year, $is_cost_report);
    }
}
