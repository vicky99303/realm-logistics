<?php

namespace App\Models\Tokopedia;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $table = 'tokopedia_order_details';
    protected $fillable = [
        'fk_order_id',
        'order_id',
        'products_id',
        'products_name',
        'products_quantity',
        'products_notes',
        'products_weight',
        'products_total_weight',
        'products_price',
        'products_total_price',
        'currency',
        'sku',
        'is_wholesale',
        'products_fulfilled_product_id',
        'products_fulfilled_quantity_deliver',
        'products_fulfilled_quantity_reject'];
}
