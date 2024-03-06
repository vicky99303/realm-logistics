<?php

namespace App\Models\Tokopedia;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Category extends Model
{
    use HasFactory;

    /**
     * @param $fs_id
     * @return \Illuminate\Support\Collection
     */
    public static function getDistinctCategory($fs_id)
    {
        return DB::table('categories')
            ->select('cid', 'name', 'user_id')
            ->where('fs_id', '=', $fs_id)
            ->where('user_id', '=', Auth::user()->id)
            ->groupBy('cid', 'name', 'user_id')
            ->get();
    }
}
