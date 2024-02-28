<?php

namespace App\Http\Controllers\ProductMove;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;

use App\Models\ProductMove;


class UpdateOrCreateInBulk extends Controller
{
    public function __invoke(Request $request): void
    {
        $view_fields_count = count(ProductMove::view_fields());

        foreach ($request->updated_rows as $row_id => $updated_cells) {
            $purchase = ProductMove::find($row_id);

            if ($purchase) {
                $purchase->update($updated_cells);
            } else {
                ProductMove::create(array_merge($updated_cells, $request->no_view_fields));
            }
        }
    }
}
