<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FamilyAssetsMachinery extends Model
{
    use HasFactory;
    protected $table = 'family_assets_machinery';
    protected $primaryKey = 'id';
}
