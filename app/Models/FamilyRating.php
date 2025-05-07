<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FamilyRating extends Model
{
    use HasFactory;
    protected $table = 'family_rating';
    protected $primaryKey = 'id';
}
