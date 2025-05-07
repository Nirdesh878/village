<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FamilyIncomeFromBusiness extends Model
{
    use HasFactory;
    protected $table = 'family_income_from_business';
    protected $primaryKey = 'id';
}
