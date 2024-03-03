<?php

namespace App\Http\Controllers\ProductMove;

include_once(app_path().'/helpers/get_form_data.php');

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;


function get_ordering_order($request) {
    $arr = get_form_data($request);
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
