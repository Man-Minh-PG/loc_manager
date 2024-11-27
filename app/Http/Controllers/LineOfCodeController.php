<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LineOfCodeController extends Controller
{
    /**
     * Summary of index
     * Show data parent task in loc
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        return view('line_of_code/index');
    }

    /**
     * Summary of detail
     * Show data child in loc
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function detail()
    {
        return view('line_of_code/detail');
    }

    /**
     * Summary of create
     * 
     * Show View import data for loc
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create()
    {
        return view('line_of_code/create');
    }

    /**
     * Summary of edit
     * Return to view edit
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit()
    {
        return view('line_of_code/edit');
    }

    public function show()
    {
        return view('line_of_code/option_all');
    }
}
