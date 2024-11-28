<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\ChildTaskLoc;

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
        'created_at', // use for eloquent
        'updated_at' // use for eloquent
    ];

    // Get data only parent task
    public function get_parent_task_with_conditions($conditions = []){
       
        if(empty($conditions['date'])) {
            $conditions += 
            [
                'date' => Carbon::now()->month
            ];
        } // default get month current
    
        // use Eloquent
        return ParentTaskLoc::whereMonth('created_at', $conditions['date'])->where('project_type', $conditions['type'])->get();
    
        // --  use query builder --
        // return DB::table('parent_tasks_loc')
        // ->whereDate('created_at', $conditions['date_search'] )
        // ->get();
        // dd(ParentTaskLoc::whereMonth('created_at', $conditions['date'])->toSql());
        // -- end Use query builder --
    }


    // Get data parent task and child task
    // if flag is true -> get full 
    // else flag is false get only 
    // doc: /c/6747ea4b-e724-800a-874c-58e84215a6fb
    public function get_data_releated_to_parent($get_full = true, $conditions = []) {
        return $this->hasMany(ChildTaskLoc::class, 'parent_id', 'id')
        ->where('project_type', $conditions['type']);
    }

}
