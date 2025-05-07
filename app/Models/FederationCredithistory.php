<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FederationCredithistory extends Model
{
    use HasFactory;
    protected $table = 'federation_credithistory';
    protected $primaryKey = 'id';
}
