<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FamilyAssets extends Model
{
    use HasFactory;
    protected $table = 'family_assets';
    protected $primaryKey = 'id';
}
