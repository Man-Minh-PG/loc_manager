<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;

class LineOfCodeController extends Controller
{
    const PW = 1;
    const BEER = 2;

    /**
     * Summary of index
     * Get data of parent task
     * 
     * Show data parent task in loc
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index($type)
    {
        $currentMonth = Carbon::now()->month;

        if($type == LineOfCodeController::BEER) {
            return view('line_of_code_beer/index');
        }
        return view('line_of_code/index');
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
