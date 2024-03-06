<?php

namespace App\Models\Tokopedia;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Etalase extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $table = 'tokopedia_etalases';
    protected $fillable = [
        'fs_id',
        'shop_id',
        'etalase_id',
        'etalase_name',
        'alias',
        'url'];
}
