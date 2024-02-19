<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

use App\Models\Product;
use App\Models\Storage;

/**
 * Post
 *
 * @mixin Builder
 */
class ProductMove extends Model
{
    use HasFactory;

    protected $hidden = [
        'id',
        'created_at',
        'updated_at',
        'product_move_type'
    ];

    protected $casts = [
        'date' => 'date:Y-m-d',
        'storage_id' => 'integer',
        'quantity' => 'integer',
        'comment' => 'string'
    ];

    protected $fillable = [
        'date',
        'product_move_type',
        'product_id',
        'quantity',
        'price',
        'storage_id',
        'comment',
    ];

    public static function view_fields() {
         return [
            'date',
            'product_id',
            'quantity',
            'price',
            'storage_id',
            'comment',
        ];
    }

    public function product() {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function storage() {
        return $this->belongsTo(Storage::class, 'storage_id');
    }

    private function setDateValue($value) {
        $date_parts = explode('/', $value);
        $this->attributes['date'] = $date_parts[2].'-'.$date_parts[0].'-'.$date_parts[1];
    }
}
