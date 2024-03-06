<?php

namespace App\Models\Tokopedia;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderDetailFulfilled extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $table = 'tokopedia_order_detail_fulfilleds';
    protected $fillable = [
        'fk_order_id',
        'order_id',
        'products_fulfilled_product_id',
        'products_fulfilled_quantity_deliver',
        'products_fulfilled_quantity_reject'];
}
