<?php


function get_search_targets($request) {
    $postfix_len = strlen('_search_target');

    $fieldwise_targets = [];
    foreach ($request->except('tablewise_search_target') as $maybe_target_field => $target) {
        if (str_contains($maybe_target_field, '_search_target')) {
            $target_field = substr($maybe_target_field, 0, -$postfix_len);
            $fieldwise_targets[$target_field] = $target;
        }
    }

    return [
        'tablewise' => $request->tablewise_search_target,
        'fieldwise' => $fieldwise_targets
    ];
}
