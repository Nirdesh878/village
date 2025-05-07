<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClusterGovernance extends Model
{
    use HasFactory;
    protected $table = 'cluster_governance';
    protected $primaryKey = 'id';
}
