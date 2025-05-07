<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FamilyIncomeThisYear extends Model
{
    use HasFactory;
    protected $table = 'family_income_this_year';
    protected $primaryKey = 'id';
}
