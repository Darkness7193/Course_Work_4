<?php

use App\helpers\pure_php\EmptyRow;




function get_filler_rows($paginator, $max_id) {
    $n = $paginator->perPage() - $paginator->count();
    $filler_rows = [];

    for ($i=0; $i<$n; $i++) {
        $FillerRow = new EmptyRow();
        $FillerRow->id = $max_id + 1 + $i;
        $filler_rows[] = $FillerRow;
    }

    return $filler_rows;
}
