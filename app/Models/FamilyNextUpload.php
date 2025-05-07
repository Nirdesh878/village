<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FamilyNextUpload extends Model
{
    use HasFactory;
    protected $table = 'family_image_nextyear';
    protected $primaryKey = 'id';
}
