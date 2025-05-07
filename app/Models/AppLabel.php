<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AppLabel extends Model
{
    use HasFactory;
    protected $table = 'mst_app_label';
    protected $primaryKey = 'id';
}
