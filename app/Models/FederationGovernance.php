<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FederationGovernance extends Model
{
    use HasFactory;
    protected $table = 'federation_governance';
    protected $primaryKey = 'id';
}
