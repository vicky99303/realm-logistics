<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BuyPackageRecord extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $table = 'buy_package_records';
    protected $fillable = [
        'user_id',
        'package_id',
        'price',
        ];
}
