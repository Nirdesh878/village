<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FedUpload extends Model
{
    use HasFactory;
    protected $table = 'federation_upload_photos_videos';
    protected $primaryKey = 'id';
}
