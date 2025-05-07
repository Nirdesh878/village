<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClusterInclusion extends Model
{
    use HasFactory;
    protected $table = 'cluster_inclusion';
    protected $primaryKey = 'id';
}
