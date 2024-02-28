<?php

namespace App\Http\Controllers\ProductMove;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;

use App\Models\ProductMove;


class UpdateOrCreateInBulk extends Controller
{
    public function __invoke(Request $request): void
    {
        foreach ($request->updated_rows as $row_id => $updated_cells) {
            $exist_purchase = ProductMove::find($row_id);

            if ($exist_purchase) {
                $exist_purchase->update($updated_cells);
            } else {
                ProductMove::create(array_merge($request->no_view_fields, $updated_cells));
            }
        }
    }
}
