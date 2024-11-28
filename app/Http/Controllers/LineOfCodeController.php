<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ParentTaskLoc;

class LineOfCodeController extends Controller
{
    const PW = 1;
    const BEER = 2;

    /**
     * Summary of index
     * Get data of parent task
     * created_at
     * 
     * Show data parent task in loc
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index($type, Request $request)
    {
        $parentTaskLoc = new ParentTaskLoc();
        $search_data   = $request->all();
        $conditions    = [];
        $parent_locs   = [];
        
        if(!empty($search_data['date_search'])){
            $conditions = [
                'date' => $search_data['date_search']
            ];
        }

        $lst_parent_locs = $parentTaskLoc->get_parent_task_with_conditions($conditions);
        // dd($lst_parent_locs);
  

        if($type == LineOfCodeController::BEER) {
            return view('line_of_code_beer/index', compact('lst_parent_locs'));
        }
        

        return view('line_of_code/index', compact('lst_parent_locs'));
    }

    /**
     * Summary of detail
     * Show data child of parent
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function detail()
    {

        return view('line_of_code/detail');
    }

    /**
     * Summary of detail_beer
     * Show data child of parent
     */
    public function detail_beer() 
    {
        return view('line_of_code/detail');
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

    /**
     * Summary of edit
     * Return to view edit
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit($type)
    {
        if($type == LineOfCodeController::BEER) {
            
        }
        return view('line_of_code/edit');
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
    public function show($type)
    {
        if($type == LineOfCodeController::BEER) {
            return view('line_of_code_beer/option_all');
        }
        return view('line_of_code/option_all');
    }

    
}
