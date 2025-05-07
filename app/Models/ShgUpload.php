<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShgUpload extends Model
{
    use HasFactory;
    protected $table = 'shg_upload_photos_videos';
    protected $primaryKey = 'id';
}
