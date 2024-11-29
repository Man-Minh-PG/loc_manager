<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\ChildTaskLoc;
use Illuminate\Support\Facades\DB;

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

    /**
    * Relationship: Get the parent of this task.
    */
    public function childTask()
    {
        return $this->hasOne(ChildTaskLoc::class);
    }

    /**
    * Relationship: Get the parent of this task.
    */
    public function childTasks()
    {
        return $this->hasMany(ChildTaskLoc::class, 'parent_id', 'id');
    }

    // Get data only parent task
    public function get_parent_task_with_conditions($conditions = []){
       
        if(empty($conditions['month'])) {
            $conditions += 
            [
                'month' => Carbon::now()->month,
                'year'  => Carbon::now()->year
            ];
        } // default get month current
    
        // use Eloquent
        return ParentTaskLoc::whereYear('created_at', $conditions['year'])
            ->whereMonth('created_at', $conditions['month'])
            ->where('project_type', $conditions['type'])->get();
    
        // --  use query builder --
        // return DB::table('parent_tasks_loc')
        // ->whereDate('created_at', $conditions['date_search'] )
        // ->get();
        // dd(ParentTaskLoc::whereMonth('created_at', $conditions['date'])->toSql());
        // -- end Use query builder --
    }

    public function get_info_releated_loc($conditions = []){
        if(empty($conditions['month'])) {
            $conditions += 
            [
                'month' => Carbon::now()->month,
                'year'  => Carbon::now()->year
            ];
        } // default get month current
    
        // use Eloquent
        return ParentTaskLoc::with('childTasks')
        ->whereYear('created_at', $conditions['year'])
        ->whereMonth('created_at', $conditions['month'])
        ->where('project_type', $conditions['type'])
        ->get();
    }
}