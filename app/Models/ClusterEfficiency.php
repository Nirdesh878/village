<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClusterEfficiency extends Model
{
    use HasFactory;
    protected $table = 'cluster_efficiency';
    protected $primaryKey = 'id';
}
