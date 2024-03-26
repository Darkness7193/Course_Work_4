<?php

namespace App\Http\Controllers\TableViewCommands;

include_once(app_path().'/helpers/get_form_data.php');
include_once(app_path().'/helpers/session_setif.php');

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;


function get_search_targets($request, $postfix) {
    $targets = get_form_data($request, $postfix);
    $tablewise = $targets['tablewise'];
    unset($targets['tablewise']);

    return [
        'tablewise' => $tablewise,
        'fieldwise' => array_filter($targets, static function($value){ return $value !== null; } )
    ];
}


class SetFilter extends Controller
{
    public function __invoke(Request $request) {
        session()->put('search_targets', $request->action === 'search' ? get_search_targets($request, '_search_target') : []);

        return to_route($request->previous_route);
    }
}












