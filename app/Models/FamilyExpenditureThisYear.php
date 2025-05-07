<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FamilyExpenditureThisYear extends Model
{
    use HasFactory;
    protected $table = 'family_expenditure_this_year';
    protected $primaryKey = 'id';
}
