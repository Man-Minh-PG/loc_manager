<?php

namespace App\Http\Controllers;

use App\Models\ChildTaskLoc;
use Illuminate\Http\Request;
use App\Models\ParentTaskLoc;
use App\Models\IndexKey;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Validators\ValidationException;
use App\Imports\CsvImport;

// use App\Http\Controllers\ToCollection;
// use App\Http\Controllers\WithHeadingRow;
// use App\Http\Controllers\Collection;

// use Illuminate\Support\Facades\DB;


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
     * Redirect to view show data child of parent
     * 
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
     * Redirect to view show data child of parent
     */
    public function detail_beer($id_parent) 
    {
        $parentTaskLoc = new ParentTaskLoc();
        $lstLocDetail  = $parentTaskLoc->get_info_releated_loc_with_parent_id($id_parent);

        return view('line_of_code/detail', compact('lstLocDetail'));
    }

    /**
     * Summary of create
     * Redirect to view import data for loc
     * Notes: Use for import step by step with GUI ( system has import with CSV)
     * 
     * Maintaince process after
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
     * Summary of showUiCSV
     * Redirect to screen Update CSV use for BEER AND PW
     * 
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function showUiCSV(){
        return view('orther/import_csv');
    } 
   
    /**
     * Summary of importCsv
     * Process logic import data in File CSV 
     * 
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function importCsv(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:csv,txt|max:2048',
        ]);

        $file = $request->file('file');

        try {
            Excel::import(new CsvImport, $file); // Reading file csv
            return redirect()->back()->with('success', 'File imported successfully!');
        } catch (ValidationException $e) {
            $failures = $e->failures(); // Lấy danh sách lỗi
            return back()->withErrors($failures);
        }
    }

    /**
     * Summary of edit
     * Redirect to screen EDIT
     * 
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit($type, $id_parent)
    {
        $parentTaskLoc = new ParentTaskLoc();
        $lstLocDetail  = $parentTaskLoc->get_info_releated_loc_with_parent_id($id_parent);
        $lstStatus     = [
            config('common.new')        => 'new',
            config('common.inProgress') => 'inProgress',
            config('common.completed')  => 'completed',
            config('common.close')      => 'close'
        ];

        if($type == LineOfCodeController::BEER) {
            return view('line_of_code_beer/edit', compact('lstLocDetail', 'lstStatus'));
        }
        return view('line_of_code/edit', compact('lstLocDetail', 'lstStatus'));
    }

    /**
    * Summary of re_edit
    * Get data - Process show UI screen re_edit
    * Redirect to screen re_edit
    * Screen: _admin/loc/re_edit
    * 
    * @param mixed $type
    * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
    */
    public function re_edit($type, Request $request) 
    {
        $parentTaskLoc = new ParentTaskLoc();
        $searchData    = $request->all();
        $lstLocs       = [];
        $statusLabel   = config('common');
        $lstIndex      = $this->getIndexKeyCurrent($type);
       
        $lstStatus     = [
            config('common.new')        => 'new',
            config('common.inProgress') => 'inProgress',
            config('common.completed')  => 'completed',
            config('common.close')      => 'close'
        ];

        $lstType     = [
            config('common.Sys') => 'Sys',
            config('common.EC')  => 'Ec',
        ];

        if(is_null($lstIndex)) {
            $lstIndex = [];
        }
        
        $conditions    = [
            'type'         => $type,
            'index_key_id' => 99999999 // key temp if not search
        ];

        if(!empty($searchData['indexKey'])) {
            $conditions['index_key_id'] = $searchData['indexKey'];
        }

        if(!empty($searchData['dateSearch'])){
            $conditions += [
                'month' => Carbon::parse($searchData['dateSearch'])->month,
                'year'  => Carbon::parse($searchData['dateSearch'])->year
            ];
        } // set conditions db

        // dd($conditions);
        $lstLocs  = $parentTaskLoc->get_info_releated_loc_re_edit($conditions);
        // dd($lstLocs);
        if($type == LineOfCodeController::BEER) {
            return view('line_of_code_beer/detail_all', compact('lstLocs', 'lstIndex', 'statusLabel', 'lstStatus', 'lstType'));
        }
        return view('line_of_code/detail_all', compact('lstLocs', 'lstIndex', 'statusLabel', 'lstStatus'));
    }

    /**
     * Summary of show
     * Redirect to screen show all data with parent and child
     * Process UI for screen ~ REPORT DATA
     * 
     * @param mixed $type
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function show($type, Request $request)
    {
        $parentTaskLoc = new ParentTaskLoc();
        $searchData    = $request->all();
        $lstLocs       = [];
        $month         = Carbon::now()->month;
        $lstMonthName = config('months');
        $monthName    = $lstMonthName[$month];

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
            return view('line_of_code_beer/option_all', compact('lstLocs', 'statusLabel', 'monthName'));
        }
        return view('line_of_code/option_all', compact('lstLocs', 'statusLabel','monthName'));
    }

    /**
     * Summary of compareData
     * Compare data bettwen curent month with last month
     * If last month empty data - return N/A in GUI (case: new task)
     * 
     * @param mixed $type
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function compareData($type, Request $request)
    {
        $parentTaskLoc = new ParentTaskLoc();
        $searchData    = $request->all();
        $conditions    = [
            'type' => $type
        ];

        $date = !empty($searchData['dateSearch'])
            ? Carbon::parse($searchData['dateSearch'])
            : Carbon::now();

        $month         = $date->month;
        $year          = $date->year;
        $lastMonthDate = $date->copy()->subMonth();

        $lstMonthName = config('months');
        $monthName    = $lstMonthName[$month] ?? 'Current Month';

        $statusLabel   = config('common');

       // get data curent month
        $currentData = $parentTaskLoc->get_info_releated_loc([
            'month' => $month,
            'year' => $year,
            'type' => $type
        ]);

       // get data last month
        $lastData = $parentTaskLoc->get_info_releated_loc([
            'month' => $lastMonthDate->month,
            'year' => $lastMonthDate->year,
            'type' => $type
        ]);

        // Map data for easier comparison
        $lastMap = $lastData->keyBy('number_task');
        $currentMap = $currentData->keyBy('number_task');

        $comparedData = $currentMap->map(function ($currentParent) use ($lastMap) {
            $lastParent = $lastMap->get($currentParent->number_task);

            $parentDiff = $lastParent ? $lastParent->total - $currentParent->total : null;

            // So sánh child
            $currentChildren = $currentParent->childTasks->keyBy('number_task');
            $lastChildren = $lastParent ? $lastParent->childTasks->keyBy('number_task') : collect();

            $childDiffs = $currentChildren->map(function ($currentChild) use ($lastChildren) {
                $lastChild = $lastChildren->get($currentChild->number_task);

                return [
                    'current_total' => $currentChild->total,
                    'last_total' => $lastChild->total ?? null,
                    'diff' => isset($lastChild) ? ($lastChild->total - $currentChild->total) : null
                ];
            });

            return [
                'parent' => $currentParent,
                'parent_diff' => $parentDiff,
                'child_diffs' => $childDiffs
            ];
        });

        if ($type == LineOfCodeController::BEER) {
            return view('line_of_code_beer/compare_all', compact('comparedData', 'statusLabel', 'monthName'));
        }

        return view('line_of_code/compare_all', compact('comparedData', 'statusLabel', 'monthName'));
    }
    
    /**
     * Summary of getIndexKeyCurrent
     * Process create indexKey
     * 
     * @param mixed $type
     * @return IndexKey[]|\Illuminate\Database\Eloquent\Collection
     */
    private function getIndexKeyCurrent($type){
        $projectName = $type == config('common.PW') ? "PW" : "BEER";
        // $index       = 1;
        $month       = Carbon::now()->month;
        
        // $key = $projectName.'_'.$month.'_'.$index;//"pw_11_01"
        $key = $projectName.'_'.$month;//"pw_11_01"

        $valueIndexKey = IndexKey::where('key_value', 'like', '%'.$key.'%')->get();
        return $valueIndexKey;
    }


    /**
     * Summary of updateLocDate
     * Process update data "Runtime" in UI (call in Ajax)
     * 
     * @param \Illuminate\Http\Request $request
     * @return mixed|\Illuminate\Http\JsonResponse
     */
    public function updateRuntime(Request $request){
        $resultUpdate = false;
        $data         = $request->all();
        $currentMonth = Carbon::now()->month;

        // Debug
        // return response()->json([
        //     'success' => false,
        //     'message' =>$data
        // ]);

        if(!isset($data['isParent']) && !isset($data['id'])) {
            return response()->json([
                'success' => false,
                'message' => 'isParent or id is empty'
            ]);
        }

        try{
            if($data['isParent'] == config('common.parentTable')) {
                $parentModel  = new ParentTaskLoc;
                // $resultUpdate = $parentModel::where('id',$data['id'])->first()->updateOrFail(['run_time' => Carbon::now()]);

                // $parentModel = ParentTaskLoc::findOrFail($data['id']);
                // $parentModel->update(['run_time' => Carbon::now()]);
                $parentModel = $parentModel::where('id', $data['id'])
                    ->where('source_type', $data['sourceType'])->whereMonth('created_at', $currentMonth)
                    ->firstOrFail();
                $parentModel->update(['run_time' => Carbon::now()]);
            }else {
                $childModel =  new ChildTaskLoc;
                // $resultUpdate = $childModel::where('id',$data['id'])->first()->updateOrFail(['run_time' => Carbon::now()]);   

                // $childModel = ChildTaskLoc::findOrFail($data['id']);
                // $childModel->update(['run_time' => Carbon::now()]);

                $childModel = $childModel::where('id', $data['id'])
                    ->where('source_type', $data['sourceType'])
                    ->firstOrFail();

                $childModel->update(['run_time' => Carbon::now()]);
            }

            return response()->json([
                'success' => true,
                'message' => 'Data updated successfully! id_update'.$data['id']
            ]);
          
        } catch (\Exception $e) { 
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong. Please try again.'.$e->getMessage()
            ]);
        }
    }


    /**
     * Summary of updateAllLoc 
     * Process update all data LOC in UI (call in Ajax update-all when submit form)
     * Screen: _admin/loc/re_edit
     * 
     * @param \Illuminate\Http\Request $request
     * @return mixed|\Illuminate\Http\JsonResponse
     */
    public function updateAllLoc(Request $request)
    {
        $currentMonth = Carbon::now()->month;
        $data    = $request->all();
        $success = [];
        $errors  = [];

        foreach ($data as $id => $fields) {
            $type = $fields['typeUpdate'];

            try {
                if ($fields['typeUpdate'] == 'parent') {
                    // $record = ParentTaskLoc::find($id);
                    $record = ParentTaskLoc::where([
                        'number_task' => $fields['numberTask'],
                        'source_type' => $fields['sourceType'],
                    ])->whereMonth('created_at', $currentMonth)->first();

                    if (!$record) {
                        $errors[] = "Record with ID {$id} not found. type: $type";
                        continue;
                    }

                    $record->status      = $fields['status'];
                    $record->file_change = $fields['fileChange'];
                    $record->php         = $fields['php'];
                    $record->js          = $fields['js'];
                    $record->css         = $fields['css'];
                    $record->tpl         = $fields['tpl'];
                    $record->total       = $fields['total'];
                    $record->branch      = $fields['branch'];
                    $record->notes       = $fields['notes'];

                    if(isset($fields['sourceType']) && !is_null($fields['sourceType']) ){
                        $record->source_type = $fields['sourceType'];
                    }
                    
                    if (!$record->save()) {
                        $errors[] = "Failed to update record with ID {$id}.";
                        continue;
                    }

                    $success[] = "Parent task with ID {$id} updated successfully.";
                } else {
                    // $record = ChildTaskLoc::find($id);
                    $record = ChildTaskLoc::where([
                        'number_task' => $fields['numberTask'],
                        'source_type' => $fields['sourceType']
                    ])->whereMonth('created_at', $currentMonth)->first();

                    if (!$record) {
                        $errors[] = "Record with ID {$id} not found. type: $type";
                        continue;
                    }

                    $record->status      = $fields['status'];
                    $record->file_change = $fields['fileChange'];
                    $record->php         = $fields['php'];
                    $record->js          = $fields['js'];
                    $record->css         = $fields['css'];
                    $record->tpl         = $fields['tpl'];
                    $record->total       = $fields['total'];
                    $record->branch      = $fields['branch'];
                    $record->notes       = $fields['notes'];

                    if(isset($fields['sourceType']) && !is_null($fields['sourceType']) ){
                        $record->source_type = $fields['sourceType'];
                    }
                    
                    if (!$record->save()) {
                        $errors[] = "Failed to update record with ID {$id}.";
                        continue;
                    }

                    $success[] = "Child task with ID {$id} updated successfully.";
                }
            } catch (\Exception $e) {
                $errors[] = "Error updating record with ID {$id}: " . $e->getMessage();
            }
        }

        return response()->json([
            'success' => $success,
            'errors'  => $errors,
        ]);
    }


    /**
     * Summary of updateDataCSV
     * Process update data in CSV into Db
     * 
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateDataCSV(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:csv,txt,xlsx|max:2048',
        ]);
        $file = $request->file('file');

        try {
            Excel::import(new CsvImport, $file);
            return redirect()->back()->with('success', 'File imported successfully!');
        } catch (ValidationException $e) {
            $failures = $e->failures();
            return back()->withErrors($failures);
        }
    }

    /**
     * Summary of updateToTal
     * Process Caculator total and update total all task
     * 
     * Caculator total of current date time
     * 
     * @param mixed $type
     * @return mixed|\Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function updateToTal($type)
    {
        $currentMonth = Carbon::now()->month;
        $arrayParent  = ParentTaskLoc::where('project_type', $type)->whereMonth('created_at', $currentMonth)->get();
        
        if ($arrayParent->isEmpty()) {
            return back()->withErrors('No records found for this project type.');
        }

        foreach ($arrayParent as $parent) {
            try {
                $childTasks = ChildTaskLoc::where(
                    [
                        'parent_id'   => $parent->id,
                    ]
                )->get();

                $totalChange = 0;
                $totalPhp    = 0;
                $totalJs     = 0;
                $totalCss    = 0;
                $totalTpl    = 0;
                $total       = 0;

                if ($childTasks->count() != 0) {
                    foreach ($childTasks as $child) {
                        $totalChange += $child->file_change ?? 0;
                        $totalPhp    += $child->php ?? 0;
                        $totalJs     += $child->js ?? 0;
                        $totalCss    += $child->css ?? 0;
                        $totalTpl    += $child->tpl ?? 0;
                        $total       += $child->total ?? 0;
                    }
    
                    $parent->update([
                        'file_change' => $totalChange,
                        'php'         => $totalPhp,
                        'js'          => $totalJs,
                        'css'         => $totalCss,
                        'tpl'         => $totalTpl,
                        'total'       => $total
                    ]);
                }
            } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
                continue;
            } catch (\Exception $e) { 
                // return response()->json([
                //     'success' => false,
                //     'message' => 'Something went wrong. Please try again.'
                // ]);
                return back()->withErrors("update failed");
                // return redirect()->back()->with('error', 'Update fail!');
            }
        }
        // return response()->json([
        //     'success' => true,
        //     'message' => 'All records processed successfully.'
        // ]);
        return redirect()->back()->with('success', 'caculator successfully!');
    }

    /**
     * Summary of getHistoryOfTask
     * Process get history of task (Call in Ajax)
     * Route::post('/getHistory', 'getHistoryOfTask')->name('loc.getHistory'); // Ajax get history data in screen re_edit
     * 
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getHistoryOfTask(Request $request)
    {
        $parentTaskLoc = new ParentTaskLoc();
        $childTaskLoc  = new ChildTaskLoc();
        $request       = $request->all();
        $lstResult     = [];

        if($request['isParent'] == config('common.parentTable')) {
            $conditions = [
                'number_task' => $request['numberTask'],
                'source_type' => $request['sourceType']
            ];

            $lstResult = $parentTaskLoc->where($conditions)->get();
        } else {
            $conditions = [
                'number_task' => $request['numberTask'],
                'source_type' => $request['sourceType']
            ];

            $lstResult = $childTaskLoc->where($conditions)->get();
        }

        if($lstResult->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'No records found for this task.'
            ]);
        }

        return response()->json([
            'success' => true,
            'data' => $lstResult
        ]);
    }

    /**
     * Summary of update
     * Update data current = data old in screen re_edit
     * Route::post('/update-old-data', 'update')->name('loc.updateOldData');    // Ajax update data in screen re_edit
     *   
     * @param \Illuminate\Http\Request $request
     * @return mixed|\Illuminate\Http\JsonResponse
     */
    public function update(Request $request)
    {
        $parentTaskLoc = new ParentTaskLoc();
        $childTaskLoc  = new ChildTaskLoc();
        $requestData   = $request->all();
        $currentMonth  = Carbon::now()->month;
        $resultUpdate  = false;
        $updatedData   = null;

        if($requestData['isParent'] == config('common.parentTable')) {
            // Get old data       
            $oldData = $parentTaskLoc->where([
                'id' => $requestData['idTaskOld'],
                'source_type' => $requestData['sourceType'],  
            ])->whereMonth('created_at', $currentMonth)->first();

            $conditions = [
                'number_task' => $requestData['numberTaskUpdate'],
                'source_type' => $requestData['sourceType']
            ];

            $resultUpdate = $parentTaskLoc->where($conditions)->whereMonth('created_at', $currentMonth)->update(
              [
                'file_change' => $oldData['file_change'],
                'php'         => $oldData['php'],
                'js'          => $oldData['js'],
                'css'         => $oldData['css'],
                'tpl'         => $oldData['tpl'],
                'total'       => $oldData['total'],
                'branch'      => $oldData['branch'],
                'notes'       => "[Dùng lại số đo cũ id: ".$oldData['id'].$oldData['notes']
              ]
            );

            if ($resultUpdate) {
                $updatedData = $parentTaskLoc->where($conditions)->whereMonth('created_at', $currentMonth)->first();
            }
        } else {
             // Get old data       
             $oldData = $childTaskLoc->where([
                'id' => $requestData['idTaskOld'],
                'source_type' => $requestData['sourceType'],  
            ])->whereMonth('created_at', $currentMonth)->first();

            $conditions = [
                'number_task' => $oldData['numberTaskUpdate'],
                'source_type' => $oldData['sourceType']
            ];

            $resultUpdate = $childTaskLoc->where($conditions)->whereMonth('created_at', $currentMonth)->update(
              [
                'file_change' => $oldData['file_change'],
                'php'         => $oldData['php'],
                'js'          => $oldData['js'],
                'css'         => $oldData['css'],
                'tpl'         => $oldData['tpl'],
                'total'       => $oldData['total'],
                'branch'      => $oldData['branch'],
                'notes'       => "[Dùng lại số đo cũ id: ".$oldData['id'].$oldData['notes']
              ]
            );

            if ($resultUpdate) {
                $updatedData = $childTaskLoc->where($conditions)->whereMonth('created_at', $currentMonth)->first();
            }
        }

        if($resultUpdate) {
            return response()->json([
                'success' => true,
                'message' => 'Data old updated successfully!',
                'data'    => $updatedData
            ]);
        }
        
        return response()->json([
            'success' => false,
            'message' => 'Something went wrong. Please try again.'
        ]);
    }

    public function getModalData(Request $request){
        $parentTaskLoc = new ParentTaskLoc();
        $childTaskLoc  = new ChildTaskLoc();
        $requestData   = $request->all();
        
         if($requestData['isParent'] == config('common.parentTable')) {
            // Get old data       
            $lstOldData = $parentTaskLoc->where([
                'number_task' => $requestData['numberTask'],
                'source_type' => $requestData['sourceType'],
                'project_type' => $requestData['projectType'], 
            ])->get();


        } else {
             // Get old data       
             $lstOldData = $childTaskLoc->where([
               'number_task' => $requestData['numberTask'],
                'source_type' => $requestData['sourceType'],
                'project_type' => $requestData['projectType'], 
             ])->get();
        }

        if($lstOldData) {
            return response()->json([
                'success' => true,
                'message' => 'Data old updated successfully!',
                'data'    =>$lstOldData 
            ]);
        }
        
        return response()->json([
            'success' => false,
            'message' => 'Something went wrong. Please try again.'
        ]);
    }

    
}
