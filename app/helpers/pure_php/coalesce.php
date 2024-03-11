<?php



function coalesce($values) {
    foreach ($values as $value) {
        if ($value !== null) { return $value; }
    }

    return null;
}
