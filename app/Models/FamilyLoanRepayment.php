<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FamilyLoanRepayment extends Model
{
    use HasFactory;
    protected $table = 'family_loan_repayment';
    protected $primaryKey = 'id';
}
