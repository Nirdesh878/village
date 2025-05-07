<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shg extends Model
{
    use HasFactory;
    protected $table = 'shg_mst';
    protected $primaryKey = 'id';
}
