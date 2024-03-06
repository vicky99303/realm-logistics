<?php

namespace App\Models\Tokopedia;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductTableCategories extends Model
{
    use HasFactory;
    protected $table = 'product_tokopedia_categories';
    protected $primaryKey = 'id';
}
