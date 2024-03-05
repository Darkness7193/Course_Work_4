<?php

namespace App\Http\Controllers\ProductMove;

include_once(app_path().'/helpers/get_form_data.php');

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;


function get_ordered_orders($request) {
    $orders_priority = array_filter(get_form_data($request, '_order_priority'), function($x){return $x !== null;} );
    asort($orders_priority);
    $ordered_order_fields = array_keys($orders_priority);

    $ordered_orders = [];
    $directions = get_form_data($request, '_order_direction');
    foreach ($ordered_order_fields as $field) {
        $ordered_orders[] = [$field, $directions[$field]];
    }

    return $ordered_orders;
}


class SetOrder extends Controller
{
    public function __invoke(Request $request){
        $is_ordering = $request->action === 'is_ordering';

        return to_route($request->target_route, [
            'ordered_orders' => $is_ordering ? get_ordered_orders($request) : null,
        ]);
    }
}
