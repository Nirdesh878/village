<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShgRating extends Model
{
    use HasFactory;
    protected $table = 'shg_rating';
    protected $primaryKey = 'id';
}
