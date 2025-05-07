<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class familyLoanDisbursement extends Model
{
    use HasFactory;
    protected $table = 'family_loan_disbursement';
    protected $primaryKey = 'id';
}
