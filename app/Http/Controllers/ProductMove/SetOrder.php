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


class SetOrder extends Controller
{
    public function __invoke(Request $request){
        $is_ordering = $request->action === 'is_ordering';
        dd(get_input_data($request));

        return to_route($request->target_route, [
            'ordering_order' => $is_ordering ? get_input_data($request) : null
        ]);
    }
}
