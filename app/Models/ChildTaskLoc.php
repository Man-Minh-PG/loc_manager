<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

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
        'path'
    ];

    /**
    * Relationship: Get the parent of this task.
    */
    public function parentTask()
    {
        return $this->belongsTo(ParentTaskLoc::class);
    }

    // Get data parent task and child task
    // if flag is true -> get full 
    // else flag is false get only 
    // doc: /c/6747ea4b-e724-800a-874c-58e84215a6fb
    public function get_child_data( $conditions = []) {
        if(empty($conditions['date'])) {
            $conditions += 
            [
                'date' => Carbon::now()->month
            ];
        }

        // use Eloquent
        return ParentTaskLoc::whereMonth('created_at', $conditions['date'])->where('project_type', $conditions['type'])->get();
    }
}
