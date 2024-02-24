<?php


function multi_fields_search(&$query, $target) {
    if (empty($target)) { return $query; }

    foreach ($query->getModel()->view_fields() as $field) {
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
