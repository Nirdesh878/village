<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FamilyYearlyOperationalExpenses extends Model
{
    use HasFactory;
    protected $table = 'family_yearly_operational_expenses';
    protected $primaryKey = 'id';
}
