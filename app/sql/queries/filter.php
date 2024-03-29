<?php

include_once(app_path().'/sql/helpers/where_field_like.php');
include_once(app_path().'/sql/helpers/where_some_field_like.php');




function filter(&$rows, $search_targets, $view_fields) {
    if ($search_targets === []) { return $rows; }

    $rows = where_some_field_like($rows, $search_targets['tablewise'] ?? null, $view_fields);

    foreach ($search_targets['fieldwise'] ?? [] as $target_field => $search_target) {
        $rows = where_field_like($rows, $search_target, $target_field);
    }

    return $rows;
}
