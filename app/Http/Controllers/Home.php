<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;

use App\Models\ProductMove;




class Home extends Controller
{
    public function __invoke(Request $request)
    {
        return view('pages/home', []);
    }
}
