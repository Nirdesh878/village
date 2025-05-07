<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FamilyLoanApprovel extends Model
{
    use HasFactory;
    protected $table = 'family_loan_approvel';
    protected $primaryKey = 'id';
}
