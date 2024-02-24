<?php

namespace App\Http\Controllers\ProductMove;

include_once(app_path().'/helpers/get_product_totals.php');

use Illuminate\Routing\Controller;
use Illuminate\View\View;
use Illuminate\Http\Request;




class ShowTotalsReportController extends Controller
{
    public function __invoke(Request $request): View
    {
        return view('pages/totals_report', ['totals' => get_product_totals($request)]);
    }
}
