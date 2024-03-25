<?php


function session_singular_setif($session_key, $new_value, $default = null)
{
    $final_value = $new_value ?? session($session_key) ?? $default;
    session()->put($session_key, $final_value);

    return $final_value;
}


function session_setif($parameters_sets)
{
    $final_values = [];

    foreach ($parameters_sets as $request_key => $value_and_or_default) {
        if (is_array($value_and_or_default)) {
            if (count($value_and_or_default) === 2) {
                [$value, $default] = $value_and_or_default;
            } else {
                $value = $value_and_or_default[0];
            }
        } else {
            $value = $value_and_or_default;
            $default = null;
        }
        $final_values[$request_key] = session_singular_setif($request_key, $value, $default);
    }

    return $final_values;
}
