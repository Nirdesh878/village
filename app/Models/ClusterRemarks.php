<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClusterRemarks extends Model
{
    use HasFactory;
    protected $table = 'cluster_remarks';
    protected $primaryKey = 'id';
}
