<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FamilyAssetsVehicle extends Model
{
    use HasFactory;
    protected $table = 'family_assets_vehicle';
    protected $primaryKey = 'id';
}
