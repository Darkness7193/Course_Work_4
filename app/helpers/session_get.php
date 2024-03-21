<?php


function session_get($keys) {
    $values = [];

    foreach ($keys as $key) {
        $values[$key] = session($key);
    }

    return $values;
}
