<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FamilyMemberInfo extends Model
{
    use HasFactory;
    protected $table = 'family_member_information';
    protected $primaryKey = 'id';
}
