<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FederationRiskMitigation extends Model
{
    use HasFactory;
    protected $table = 'federation_risk_mitigation';
    protected $primaryKey = 'id';
}
