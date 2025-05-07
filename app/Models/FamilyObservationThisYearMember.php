<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FamilyObservationThisYearMember extends Model
{
    use HasFactory;
    protected $table = 'family_observation_this_year_member';
    protected $primaryKey = 'id';
}
