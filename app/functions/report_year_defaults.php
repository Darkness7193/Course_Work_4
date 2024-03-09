<?php


function report_year_defaults($report_year, $used_years) {
    if ($report_year) {
        return $report_year;
    } else if (in_array(now()->year, $used_years)) {
        return now()->year;

    } else if (!empty($used_years)) {
        return $used_years[0];
    } else {
        return 'Года отчета отсутствуют';
    }
}
