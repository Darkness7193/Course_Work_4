<?php

namespace App\Http\Controllers\TableViewCommands;

use App\Models\ProductMove;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;


class UpdateOrCreateInBulk extends Controller
{
    public function __invoke(Request $request): void
    {
        $fillable_count = count((new $request->CrudModel)->getFillable());
        foreach ($request->updated_rows as $row_id => $updated_cells)
        {
            $exist_purchase = $request->CrudModel::find($row_id);
            if ($exist_purchase) {
                $exist_purchase->update($updated_cells);
            } else {
                $new_purchase = array_merge($request->no_view_fields, $updated_cells);
                if (count($new_purchase) === $fillable_count) {
                    $request->CrudModel::create($new_purchase);
                }
            }
        }
    }
}
