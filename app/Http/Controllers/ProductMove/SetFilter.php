<?php

namespace App\Http\Controllers\ProductMove;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;


function get_search_targets($request) {
    $targets = [];
    $postfix_len = strlen('_search_target');

    foreach ($request->all() as $maybe_search_field => $value) {
        if (str_contains($maybe_search_field, '_search_target')) {
            $search_field = substr($maybe_search_field, 0, -$postfix_len);
            $targets[$search_field] = $value;
        }
    }
    return $targets;
}


class SetFilter extends Controller
{
    public function __invoke(Request $request){
        $is_un_search = $request->action === 'un_search';

        return to_route($request->target_route, [
            'search_targets' => $is_un_search ? null : get_search_targets($request)
        ]);
    }
}












