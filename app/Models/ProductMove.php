<?php

namespace App\Models;

use App\Models\Storage;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;


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
        'start_storage_id',
        'end_storage_id',

        'product_id',
        'quantity',
        'price',

        'comment',
    ];

    public static function product_move_types() {
        return ['purchasing', 'selling', 'liquidating', 'inventory', 'transfering'];
    }

    public static function inner_move_types() {
        return ['liquidating', 'inventory', 'transfering'];
    }

    public static function inner_move_types_ru() {
        return [
            'liquidating' => 'Ликвидация',
            'inventory' => 'Инвентаризация',
            'transfering' => 'Перевоз'
        ];
    }

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

    public function start_storage() {
        return $this->belongsTo(Storage::class, 'start_storage_id');
    }

    public function end_storage() {
        return $this->belongsTo(Storage::class, 'end_storage_id');
    }
}
