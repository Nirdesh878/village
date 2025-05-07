<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClusterAnalysis extends Model
{
    use HasFactory;
    protected $table = 'cluster_analysis';
    protected $primaryKey = 'id';
}
