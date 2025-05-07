<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClusterRating extends Model
{
    use HasFactory;
    protected $table = 'cluster_rating';
    protected $primaryKey = 'id';
}
