<?php

namespace App\Http\Controllers\ProductMove;

include_once(app_path().'/helpers/get_form_data.php');

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;




function get_search_targets($request, $postfix) {
    $targets = get_form_data($request, $postfix);
    $tablewise = $targets['tablewise'];
    unset($targets['tablewise']);

    return [
        'tablewise' => $tablewise,
        'fieldwise' => $targets
    ];
}


class SetFilter extends Controller
{
    public function __invoke(Request $request){
        $is_un_search = $request->action === 'un_search';

        return to_route($request->target_route, [
            'search_targets' => $is_un_search ? null : get_search_targets($request, '_search_target')
        ]);
    }
}












