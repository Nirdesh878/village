<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FamilyFixedInvestment extends Model
{
    use HasFactory;
    protected $table = 'family_fixed_investment';
    protected $primaryKey = 'id';
}
