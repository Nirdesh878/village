<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FederationEfficiency extends Model
{
    use HasFactory;
    protected $table = 'federation_efficiency';
    protected $primaryKey = 'id';
}
