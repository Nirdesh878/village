<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FamilyAssetsGadgets extends Model
{
    use HasFactory;
    protected $table = 'family_assets_gadgets';
    protected $primaryKey = 'id';
}
