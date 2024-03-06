<?php

namespace App\Models\Tokopedia;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StoreManagemnt extends Model
{
    use HasFactory;

    protected $table = 'store_managemnts';
    protected $primaryKey = 'id';
    protected $fillable = [
        'token_id',
        'fs_id',
        'user_id',
        'suser_id',
        'shop_id',
        'shop_name',
        'logo',
        'shop_url',
        'is_open',
        'status',
        'date_shop_created',
        'domain',
        'admin_id',
        'reason',
        'district_id',
        'province_name',
        'warehouse_id',
        'partner_id_Int64',
        'partner_id_Valid',
        'wshop_id_Int64',
        'wshop_id_Valid',
        'warehouse_name',
        'wdistrict_id',
        'district_name',
        'city_id',
        'city_name',
        'province_id',
        'wprovince_name',
        'wstatus',
        'postal_code',
        'is_default',
        'latlon',
        'latitude',
        'longitude',
        'email',
        'address_detail',
        'phone',
        'subscribe_tokocabang',
        'created_at',
        'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function getOrderDetail()
    {
        return $this->hasMany(Orders::class, 'fs_id', 'fs_id');
    }

    public function productDetail(){
        return $this->hasManyThrough(
            Product::class, // Foreign key on the owners table...
            Orders::class, // Foreign key on the cars table...
            'fs_id', // Foreign key on the cars table...
            'shop_id', // Foreign key on the owners table...
            'fs_id', // Local key on the mechanics table...
            'shop_id' // Local key on the cars table...
        );
    }
}
