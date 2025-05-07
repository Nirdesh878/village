<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FederationProfile extends Model
{
    use HasFactory;
    protected $table = 'federation_profile';
    protected $primaryKey = 'id';
}
