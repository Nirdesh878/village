<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SHGRemarks extends Model
{
    use HasFactory;
    protected $table = 'shg_remarks';
    protected $primaryKey = 'id';
}
