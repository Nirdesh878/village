<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FamilyAnalysisThisYear extends Model
{
    use HasFactory;
    protected $table = 'family_analysis_this_year';
    protected $primaryKey = 'id';
}
