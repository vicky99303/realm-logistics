<?php

namespace App\Models\Tokopedia;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tokopediaAuthTokenLifeInfo extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $table = 'tokopedia_auth_token_life_infos';
    protected $fillable = ['user_id', 'token_id', 'access_token', 'event_code', 'expires_in', 'last_login_type', 'sq_check', 'token_type'];

    public function Token()
    {
        return $this->belongsTo(TokopediaToken::class,'id');
    }


}
