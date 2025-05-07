<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FederationRating extends Model
{
    use HasFactory;
    protected $table = 'federation_rating';
    protected $primaryKey = 'id';
}
