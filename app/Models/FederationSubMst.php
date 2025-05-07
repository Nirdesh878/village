<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FederationSubMst extends Model
{
    use HasFactory;
    protected $table = 'federation_sub_mst';
    protected $primaryKey = 'id';
}
