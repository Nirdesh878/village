<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sync_log_data extends Model
{
    use HasFactory;
    protected $table = 'sync_log_data';
    protected $primaryKey = 'id';
}
