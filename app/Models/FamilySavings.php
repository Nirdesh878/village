<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FamilySavings extends Model
{
    use HasFactory;
    protected $table = 'family_savings';
    protected $primaryKey = 'id';
}
