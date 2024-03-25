<?php

namespace App\Http\Controllers;

include_once(app_path().'/sql/queries/filter_order_paginate.php');
include_once(app_path().'/helpers/pure_php/EmptyRow.php');
include_once(app_path().'/helpers/pure_php/get_columns.php');

use App\helpers\pure_php\EmptyRow;
use App\Models\Product;
use App\Models\Storage;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\View\View;


class StorageController extends Controller
{
    public function index(Request $request): View
    {
        [$view_fields, $headers] = get_columns([
            ['name', 'Наименование'],

            ['address', 'Адрес'],
            ['phone_number', 'Номер'],
            ['email', 'Эл. почта'],

            ['comment', 'Комментарий'],
        ]);

        if ($request->per_page) { $request->session()->put('per_page', $request->per_page); }
        $storages = Storage::query();

        return view('pages/cruds/storages-crud', [
            'paginator' => filter_order_paginate($storages, $view_fields, $request, ['created_at', 'asc']),
            'Storage' => Storage::class,
            'max_id' => Storage::max('id'),
            'emptyRow' => new EmptyRow(),
            'search_targets' => $request->search_targets
        ] + compact('view_fields', 'headers'));
    }
}
