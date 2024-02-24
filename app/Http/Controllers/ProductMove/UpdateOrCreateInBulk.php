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
            } else if (count($updated_cells) === $view_fields_count) {
                ProductMove::create(array_merge($updated_cells, ['product_move_type' => $request->product_move_type]));
            }
        }
    }
}
