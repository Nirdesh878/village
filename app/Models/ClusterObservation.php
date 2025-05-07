<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClusterObservation extends Model
{
    use HasFactory;
    protected $table = 'cluster_observation';
    protected $primaryKey = 'id';
}
