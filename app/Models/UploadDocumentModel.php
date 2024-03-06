<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UploadDocumentModel extends Model
{
    use HasFactory;
    protected $table = 'upload_doc';
    protected $fillable = [
        'user_id',
        'path',
    ];
}
