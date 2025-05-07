<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FamilyUpload extends Model
{
    use HasFactory;
    protected $table = 'family_upload_photos_videos';
    protected $primaryKey = 'id';
}
