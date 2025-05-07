<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FamilySavingsSource extends Model
{
    use HasFactory;
    protected $table = 'family_savings_source';
    protected $primaryKey = 'id';
}
