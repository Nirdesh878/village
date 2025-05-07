<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FamilyExpenditureNextYear extends Model
{
    use HasFactory;
    protected $table = 'family_expenditure_next_year';
    protected $primaryKey = 'id';
}
