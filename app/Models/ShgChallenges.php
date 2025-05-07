<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShgChallenges extends Model
{
    use HasFactory;
    protected $table = 'shg_challenges';
    protected $primaryKey = 'id';
}
