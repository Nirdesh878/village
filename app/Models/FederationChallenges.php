<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FederationChallenges extends Model
{
    use HasFactory;
    protected $table = 'federation_challenges';
    protected $primaryKey = 'id';
}
