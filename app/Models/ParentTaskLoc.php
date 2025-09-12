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
        'path',
        'run_time'
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

    /**
     * Summary of get_info_releated_loc
     * @param mixed $conditions
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     * 
     * Notes: Return Collection object not return Array
     */
    public function get_info_releated_loc($conditions = []){
        if(empty($conditions['month'])) {
            $conditions += 
            [
                'month' => Carbon::now()->month,
                'year'  => Carbon::now()->year
            ];
        } // default get month current

        // $query = ParentTaskLoc::with('childTasks')
        //     ->whereYear('created_at', $conditions['year'])
        //     ->whereMonth('created_at', $conditions['month'])
        //     ->where('project_type', $conditions['type']);

        // dd($query->toSql(), $query->getBindings()); // add debug SQL

        // use Eloquent
        return ParentTaskLoc::with('childTasks')
        ->whereYear('created_at', $conditions['year'])
        ->whereMonth('created_at', $conditions['month'])
        ->where('project_type', $conditions['type'])
        ->get();
    }

    public function get_info_releated_loc_with_list_number_task($list_number_task = []) {
        if(empty($list_number_task) || !is_array($list_number_task)) {
            return [];
        }

        $current_month = Carbon::now()->month;

        // use Eloquent
       return ParentTaskLoc::with('childTasks')
        ->whereIn('parent_tasks_loc.number_task', $list_number_task)
        ->whereMonth('created_at', '<>', $current_month)
        ->orderBy('created_at', 'ASC') // Sắp xếp theo ngày gần nhất
        ->get();
        // ->groupBy('number_task'); // Nhóm theo number_task sau khi truy vấn

        // $query = ParentTaskLoc::with('childTasks')
        //     ->whereIn('parent_tasks_loc.number_task', $list_number_task)
        //     ->whereMonth('created_at', '<>', $current_month)
        //     ->orderBy('created_at', 'desc'); // Sắp xếp theo ngày gần nhất

        // // Debug SQL và các giá trị bindings
        // dd($query->toSql(), $query->getBindings());

        // // Thực hiện truy vấn và nhóm theo number_task sau khi truy vấn
        // $results = $query->get()->groupBy('number_task');        
    }

    public function get_info_releated_loc_with_parent_id($id_parent) {
        if(empty($id_parent)) {
            return [];
        }

        // use Eloquent
        return ParentTaskLoc::with('childTasks')
        ->where('parent_tasks_loc.id', $id_parent)
        ->get();
    }

    /**
     * Summary of get_info_releated_loc_re_edit
     * @param mixed $conditions
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public function get_info_releated_loc_re_edit($conditions = []){
        if(empty($conditions['month'])) {
            $conditions += 
            [
                'month' => Carbon::now()->month,
                'year'  => Carbon::now()->year,
            ];
        } // default get month current
    
        // use Eloquent
        $result = ParentTaskLoc::with('childTasks')
        ->whereYear('created_at', $conditions['year'])
        ->whereMonth('created_at', $conditions['month'])
        ->where('project_type', $conditions['type'])
        ->where('index_key_id', $conditions['index_key_id'])
        ->whereNull('deleted_at')
        ->get();

        // dd($result);
        return $result;
    }
}