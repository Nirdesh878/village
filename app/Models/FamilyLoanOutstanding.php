<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FamilyLoanOutstanding extends Model
{
    use HasFactory;
    protected $table = 'family_loan_outstanding';
    protected $primaryKey = 'id';
}
