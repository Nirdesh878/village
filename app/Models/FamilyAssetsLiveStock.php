<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FamilyAssetsLiveStock extends Model
{
    use HasFactory;
    protected $table = 'family_assets_live_stock';
    protected $primaryKey = 'id';
}
