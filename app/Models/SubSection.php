<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubSection extends Model
{
    use HasFactory;
    protected $table = 'mst_sub_section';
    protected $primaryKey = 'id';
}
