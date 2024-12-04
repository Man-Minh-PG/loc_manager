<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Carbon\Carbon;

class ParentTaskLoc extends Model
{
    use HasFactory;

     // Chỉ định tên bảng chính xác trong cơ sở dữ liệu
    protected $table = 'parent_tasks_loc'; 

    protected $fillable = [
        'id',
        'index_key_id',
        'project_type',
        'number_task',
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

    // Get data only parent task
    public function get_parent_task_with_conditions($conditions = []){
        if(empty($conditions)) {
            $conditions['date']  = Carbon::now()->month;
        } // default get month current
        
        // --  Use query builder --
        // return DB::table('parent_tasks_loc')
        // ->whereDate('created_at', $conditions['date_search'] )
        // ->get();

        // use Eloquent
        return ParentTaskLoc::whereDate('created_at', $conditions['date'])->get();
    }


    // Get data parent task and child task
    // if flag is true -> get full 
    // else flag is false get only 
    public function get_data_releated_to_parent() {

    }

}
