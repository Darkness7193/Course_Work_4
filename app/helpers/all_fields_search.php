<?php


function all_fields_search(&$query, $model, $target) {
    if (empty($target)) {
        return $query;
    }

    foreach ($model::view_fields() as $field) {
        $is_foreing_id = str_contains($field, 'id');

        if ($is_foreing_id) {
            $foreign_record = substr($field, 0, -3);
            $query = $query->orWhereRelation($foreign_record, 'name', 'like', $target);
        } else {
            $query = $query->orWhere($field, 'like', $target);
        }
    }

    return $query;
}
