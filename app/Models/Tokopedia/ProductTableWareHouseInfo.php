<?php

namespace App\Models\Tokopedia;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductTableWareHouseInfo extends Model
{
    use HasFactory;
    protected $table = 'product_tokopedia_ware_house_infos';
    protected $primaryKey = 'id';
}
