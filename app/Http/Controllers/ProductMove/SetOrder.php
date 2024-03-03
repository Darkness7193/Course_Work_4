<?php

namespace App\Http\Controllers\ProductMove;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;


function get_input_data($request, $postfix='_input_data')
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


function get_ordering_order($request) {
    $arr = get_input_data($request);
    $arr = array_filter($arr, function($value){return $value !== null;} );
    asort($arr);
    return array_keys($arr);
}


class SetOrder extends Controller
{
    public function __invoke(Request $request){
        $is_ordering = $request->action === 'is_ordering';

        return to_route($request->target_route, [
            'ordering_order' => $is_ordering ? get_ordering_order($request) : null
        ]);
    }
}