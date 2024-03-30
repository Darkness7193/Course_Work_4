<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;





class HomeController extends Controller
{
    public function index(Request $request)
    {
        return view('pages/home', []);
    }
}
