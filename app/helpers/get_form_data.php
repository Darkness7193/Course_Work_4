<?php


function get_form_data($request, $postfix='_input_data')
{
    $postfix_len = strlen($postfix);

    $input_datas = [];
    foreach ($request->all() as $maybe_input_name => $input_value) {
        if (str_contains($maybe_input_name, $postfix)) {
            $input_name = substr($maybe_input_name, 0, -$postfix_len);
            $input_datas[$input_name] = $input_value;
        }
    }

    return $input_datas;
}
