<?php


function get_report_year($report_year, $used_years) {
    if ($report_year) {
        return $report_year;
    } else if (!empty($used_years)) {
        return max($used_years);
    } else {
        return null;
    }
}
