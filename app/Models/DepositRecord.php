<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DepositRecord extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $table = 'deposit_records';
    protected $fillable = [
        'user_id',
        'current_amount',
        'used_amount',
    ];
}
