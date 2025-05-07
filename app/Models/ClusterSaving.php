<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClusterSaving extends Model
{
    use HasFactory;
    protected $table = 'cluster_saving';
    protected $primaryKey = 'id';
}
