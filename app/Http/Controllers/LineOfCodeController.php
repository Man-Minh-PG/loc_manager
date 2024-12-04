<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ParentTaskLoc;
use App\Models\ChildTaskLoc;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Validators\ValidationException;
use App\Imports\CsvImport;

class LineOfCodeController extends Controller
{
    const PW = 1;
    const BEER = 2;

    /**
     * Summary of index
     * Get data of parent task
     * conditions get data created_at
     * 
     * Show data parent task in loc
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index($type, Request $request)
    {
        $parentTaskLoc = new ParentTaskLoc();
        $searchData    = $request->all();
        $conditions    = [
            'type' => $type
        ];
        $statusLabel   = config('common');

        if(!empty($searchData['dateSearch'])){
            $conditions += [
                'month' => Carbon::parse($searchData['dateSearch'])->month,
                'year'  => Carbon::parse($searchData['dateSearch'])->year
            ];
        } // set conditions db

        $lstParentlocs = $parentTaskLoc->get_parent_task_with_conditions($conditions);
        // dd($lstParentlocs);
  

        if($type == LineOfCodeController::BEER) {
            return view('line_of_code_beer/index', compact('lstParentlocs', 'statusLabel'));
        }
        

        return view('line_of_code/index', compact('lstParentlocs', 'statusLabel'));
    }

    /**
     * Summary of detail
     * Show data child of parent
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function detail($id_parent)
    {
      
        $parentTaskLoc = new ParentTaskLoc();
        $lstLocDetail  = $parentTaskLoc->get_info_releated_loc_with_parent_id($id_parent);

        return view('line_of_code/detail', compact('lstLocDetail'));
    }

    /**
     * Summary of detail_beer
     * Show data child of parent
     */
    public function detail_beer($id_parent) 
    {
        $parentTaskLoc = new ParentTaskLoc();
        $lstLocDetail  = $parentTaskLoc->get_info_releated_loc_with_parent_id($id_parent);

        return view('line_of_code/detail', compact('lstLocDetail'));
    }

    /**
     * Summary of create
     * 
     * Show View import data for loc
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create($type)
    {
        if($type == LineOfCodeController::BEER) {
            return view('line_of_code_beer/create');
        }
        return view('line_of_code/create');
    }

    public function importCsv(Request $request)
    {
        try {
            Excel::import(new CsvImport, $request->file('file')); // Reading file csv
            return redirect()->back()->with('success', 'File imported successfully!');
        } catch (ValidationException $e) {
            $failures = $e->failures(); // Lấy danh sách lỗi
            return back()->withErrors($failures);
        }
    }

    /**
     * Summary of edit
     * Return to view edit
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit($type, $id_parent)
    {
        $parentTaskLoc = new ParentTaskLoc();
        $lstLocDetail  = $parentTaskLoc->get_info_releated_loc_with_parent_id($id_parent);
        $lstStatus     = [
            config('common.new') => 'new',
            config('common.inProgress') => 'inProgress',
            config('common.completed') => 'completed',
            config('common.close') => 'close'
        ];

        if($type == LineOfCodeController::BEER) {
            return view('line_of_code_beer/edit', compact('lstLocDetail', 'lstStatus'));
        }
        return view('line_of_code/edit', compact('lstLocDetail', 'lstStatus'));
    }

    /**
     * Summary of re_edit
     * @param mixed $type
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function re_edit($type) 
    {
        if($type == LineOfCodeController::BEER) {
            return view('line_of_code_beer/detail_all');
        }
        return view('line_of_code/detail_all');
    }

    /**
     * Summary of show
     * 
     * Show all data with parent and child
     * 
     * @param mixed $type
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function show($type, Request $request)
    {
        $parentTaskLoc = new ParentTaskLoc();
        $searchData    = $request->all();
        $lstLocs       = [];
        $conditions    = [
            'type' => $type
        ];
        $statusLabel   = config('common');

        if(!empty($searchData['dateSearch'])){
            $conditions += [
                'month' => Carbon::parse($searchData['dateSearch'])->month,
                'year'  => Carbon::parse($searchData['dateSearch'])->year
            ];
        } // set conditions db
        $lstLocs  = $parentTaskLoc->get_info_releated_loc($conditions);

        if($type == LineOfCodeController::BEER) {
            return view('line_of_code_beer/option_all', compact('lstLocs', 'statusLabel'));
        }
        return view('line_of_code/option_all', compact('lstLocs', 'statusLabel'));
    }    
}
