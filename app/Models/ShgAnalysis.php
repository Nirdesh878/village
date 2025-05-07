<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShgAnalysis extends Model
{
    use HasFactory;
    protected $table = 'shg_analysis';
    protected $primaryKey = 'id';
}
