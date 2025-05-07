<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClusterChallenges extends Model
{
    use HasFactory;
    protected $table = 'cluster_challenges';
    protected $primaryKey = 'id';
}
