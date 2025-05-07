<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FamilyGoals extends Model
{
    use HasFactory;
    protected $table = 'family_goals';
    protected $primaryKey = 'id';
}
