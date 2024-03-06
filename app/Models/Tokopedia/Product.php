<?php

namespace App\Models\Tokopedia;

use App\Models\Tokopedia\ProductImages;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Tokopedia\ProductTableCategories;
use App\Models\Tokopedia\ProductStock;

class Product extends Model
{
    use HasFactory;

    protected $table = 'product_tokopedia';
    protected $primaryKey = 'id';
    protected $fillable = [
        'fs_id',
        'product_id',
        'shop_id',
        'status',
        'name',
        'must_insurance',
        'condition',
        'child_category_id',
        'short_desc',
        'create_time_unix',
        'update_time_unix',
        'price_value',
        'price_currency',
        'price_Last_update_unix',
        'price_idr',
        'weight_value',
        'weight_unit',
        'main_stock',
        'min_order',
        'created_at',
        'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function getImages()
    {
        return $this->hasMany(ProductImages::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function getCategories()
    {
        return $this->hasMany(ProductTableCategories::class);
    }

    /**
     * This is used to get stock values
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function getStock()
    {
        return $this->hasOne(ProductStock::class);
    }
}
