<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sync_data extends Model
{
    use HasFactory;
    protected $table = 'sync_data';
    protected $primaryKey = 'id';
}
