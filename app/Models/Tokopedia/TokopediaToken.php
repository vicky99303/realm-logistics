<?php

namespace App\Models\Tokopedia;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TokopediaToken extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $table = 'tokopedia_tokens';
    protected $fillable = ['client_id', 'client_secret', 'app_id', 'base64'];

    public function authtokens()
    {
        return $this->hasOne(tokopediaAuthTokenLifeInfo::class, 'token_id');
    }

    public function getShopInfo()
    {
        return $this->hasMany(StoreManagemnt::class, 'token_id');
    }

    public function getAllProductInfo(){
        return $this->hasMany(Product::class, 'fs_id','app_id');
    }

    public function getOrderDetail(){
        return $this->hasMany(Orders::class, 'fs_id','app_id');
    }
}
