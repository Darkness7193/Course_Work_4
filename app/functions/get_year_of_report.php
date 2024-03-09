<?php


function get_year_of_report($request, $used_years) {
    if ($request->year_of_report) {
        return $request->year_of_report;
    } else if (in_array(now()->year, $used_years)) {
        return now()->year;

    } else if (!empty($used_years)) {
        return $used_years[0];
    } else {
        return 'Материал отчета отсутствует, поэтому годов отчета нет';
    }
}
