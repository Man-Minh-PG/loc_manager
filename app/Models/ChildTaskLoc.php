<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChildTaskLoc extends Model
{
    use HasFactory;

     // Chỉ định tên bảng chính xác trong cơ sở dữ liệu
    protected $table = 'child_tasks_loc'; 

    protected $fillable = [
        'id',
        'parent_id',
        'number_task',
        'project_type',
        'status',
        'source_type',
        'file_change',
        'php',
        'js',
        'css',
        'tpl',
        'total',
        'branch',
        'notes',
        'path',
        'run_time'
    ];

}
