<?php


function is_foreing_id($field) { return str_contains($field, 'id'); }
function get_foreign_name($foreign_id) { return substr($foreign_id, 0, -3); }


function where_field_like(&$rows, $target, $search_field) {
    if (empty($target)) { return $rows; }

    return is_foreing_id($search_field)
        ? $rows->orWhereRelation(get_foreign_name($search_field), 'name', 'like', "%$target%")
        : $rows->orWhere($search_field, 'like', "%$target%");
}


function where_some_field_like(&$rows, $target, $search_fields) {
    if (empty($target)) { return $rows; }

    return $rows->where( function($rows) use($target, $search_fields)
    {
        foreach ($search_fields as $field) {
            where_field_like($rows, $target, $field);
        }
    });
}
