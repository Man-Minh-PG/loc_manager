<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
     /**
     * Display a listing of the resource.
     *
     * View\Factory
     */
    public function index(Request $request)
    {         
        return view('dashboard/index'); // View temp change after complete
    }
}
