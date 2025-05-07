<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClusterUpload extends Model
{
    use HasFactory;
    protected $table = 'cluster_upload_photos_videos';
    protected $primaryKey = 'id';
}
