<?php


function where_some_field_like(&$query, $target) {
    if (empty($target)) { return $query; }
    $target = "%$target%";

    return $query->where( function($query) use($target) {
        foreach ($query->getModel()->view_fields() as $field) {
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
