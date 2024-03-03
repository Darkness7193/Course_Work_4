<?php


function get_search_targets($request) {
    $targets = [];
    $postfix_len = strlen('_search_target');

    foreach ($request->all() as $maybe_search_field => $value) {
        if (str_contains($maybe_search_field, '_search_target')) {
            $search_field = substr($maybe_search_field, 0, -$postfix_len);
            $targets[$search_field] = $value;
        }
    }
    return $targets;
}
