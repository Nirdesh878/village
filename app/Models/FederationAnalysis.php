<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FederationAnalysis extends Model
{
    use HasFactory;
    protected $table = 'federation_analysis';
    protected $primaryKey = 'id';
}
