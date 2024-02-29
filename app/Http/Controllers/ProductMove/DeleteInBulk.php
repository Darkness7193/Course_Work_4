<?php

namespace App\Http\Controllers\ProductMove;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;

use App\Models\ProductMove;




class DeleteInBulk extends Controller
{
    public function __invoke(Request $request): void
    {
        $ids = $request->all()['deleted_rows'];
        foreach ($ids as $id) {
            ProductMove::find($id)->delete();
        }
    }
}
