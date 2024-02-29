<?php


function where_some_field_like(&$query, $target, $search_fields=null) {
    if (empty($target)) { return $query; }
    $target = "%$target%";

    return $query->where( function($query) use($target, $search_fields) {
        foreach ($search_fields ?? array_keys($query->first()->toArray()) as $field) {
            $is_foreing_id = str_contains($field, 'id');

            if ($is_foreing_id) {
                $foreign_record = substr($field, 0, -3);
                $query = $query->orWhereRelation($foreign_record, 'name', 'like', $target);
            } else {
                $query = $query->orWhere($field, 'like', $target);
            }
        }
    });
}
