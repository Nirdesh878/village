<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FamilyObservationNextYear extends Model
{
    use HasFactory;
    protected $table = 'family_observation_next_year';
    protected $primaryKey = 'id';
}
