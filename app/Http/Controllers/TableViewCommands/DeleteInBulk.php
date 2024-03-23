<?php

namespace App\Http\Controllers\TableViewCommands;

use App\Models\ProductMove;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;


class DeleteInBulk extends Controller
{
    public function __invoke(Request $request): void
    {
        $ids = $request->all()['deleted_rows'];
        foreach ($ids as $id) {
            $request->CrudModel::find($id)->delete();
        }
    }
}
