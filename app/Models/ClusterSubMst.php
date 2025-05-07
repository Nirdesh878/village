<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClusterSubMst extends Model
{
    use HasFactory;
    protected $table = 'cluster_sub_mst';
    protected $primaryKey = 'id';
}
