<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FamilyIncomeNextYear extends Model
{
    use HasFactory;
    protected $table = 'family_income_next_year';
    protected $primaryKey = 'id';
}
