<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FamilyAgricultureProductionThisYear extends Model
{
    use HasFactory;
    protected $table = 'family_agriculture_production_this_year';
    protected $primaryKey = 'id';
}
