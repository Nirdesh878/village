<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FamilyOtherIncomeThisYear extends Model
{
    use HasFactory;
    protected $table = 'family_other_income_this_year';
    protected $primaryKey = 'id';
}
