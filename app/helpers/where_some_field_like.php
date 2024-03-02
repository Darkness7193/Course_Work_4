<?php


function is_foreing_id($field) { return str_contains($field, 'id'); }
function get_foreign_name($foreign_id) { return substr($foreign_id, 0, -3); }


function where_some_field_like(&$query, $target, $search_fields=null) {
    if (empty($target)) { return $query; }

    return $query->where( function($query) use($target, $search_fields) {
        foreach ($search_fields as $field)
        {
            $query = is_foreing_id($field)
                ? $query->orWhereRelation(get_foreign_name($field), 'name', 'like', "%$target%")
                : $query->orWhere($field, 'like', "%$target%");
        }
    });
}
