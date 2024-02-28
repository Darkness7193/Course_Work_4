<?php

namespace App\Http\Controllers\ProductMove;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;

use App\Models\ProductMove;


class UpdateOrCreateInBulk extends Controller
{
    public function __invoke(Request $request): void
    {
        $fillable_count = count((new ProductMove)->getFillable());
        foreach ($request->updated_rows as $row_id => $updated_cells)
        {
            $exist_purchase = ProductMove::find($row_id);
            if ($exist_purchase) {
                $exist_purchase->update($updated_cells);
            } else {
                $new_row = array_merge($request->no_view_fields, $updated_cells);
                $is_all_fields_filled = count($new_row) === $fillable_count;
                if ($is_all_fields_filled) {
                    ProductMove::create($new_row);
                }
            }
        }
    }
}
