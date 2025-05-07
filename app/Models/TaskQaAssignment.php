<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TaskQaAssignment extends Model
{
    use HasFactory;
    protected $table = 'task_qa_assignment';
    protected $primaryKey = 'id';
}
