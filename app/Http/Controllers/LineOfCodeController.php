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

use App\Http\Controllers\ToCollection;
use App\Http\Controllers\WithHeadingRow;
use App\Http\Controllers\Collection;

use Illuminate\Support\Facades\DB;


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

    public function showUiCSV(){
        return view('orther/import_csv');
    } 
    
    public function importCsv(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:csv,txt|max:2048', // Kiểm tra định dạng file
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
    public function re_edit($type, Request $request) 
    {
        $parentTaskLoc = new ParentTaskLoc();
        $searchData    = $request->all();
        $lstLocs       = [];
        $statusLabel   = config('common');
        $lstIndex      = $this->getIndexKeyCurrent($type);
       
        $lstStatus     = [
            config('common.new') => 'new',
            config('common.inProgress') => 'inProgress',
            config('common.completed') => 'completed',
            config('common.close') => 'close'
        ];
        if(is_null($lstIndex)) {
            $lstIndex = [];
        }
        $conditions    = [
            'type'         => $type,
            'index_key_id' => 99999999
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
        $lstLocs  = $parentTaskLoc->get_info_releated_loc_re_edit($conditions);

        if($type == LineOfCodeController::BEER) {
            return view('line_of_code_beer/detail_all', compact('lstLocs', 'lstIndex', 'statusLabel', 'lstStatus'));
        }
        return view('line_of_code/detail_all', compact('lstLocs', 'lstIndex', 'statusLabel', 'lstStatus'));
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
    
    private function getIndexKeyCurrent($type){
        $projectName = $type == config('common.PW') ? "PW" : "BEER";
        // $index       = 1;
        $month       = Carbon::now()->month;
        
        // $key = $projectName.'_'.$month.'_'.$index;//"pw_11_01"
        $key = $projectName.'_'.$month;//"pw_11_01"

        $valueIndexKey = IndexKey::where('key_value', 'like', '%'.$key.'%')->get();
        return $valueIndexKey;
    }

    public function updateLocDate(Request $request){
        $resultUpdate = false;
        $data         = $request->all();

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
            if($data['isParent'] == 1) {
                // $parentModel  = new ParentTaskLoc;
                // $resultUpdate = $parentModel::where('id',$data['id'])->first()->updateOrFail(['run_time' => Carbon::now()]);

                $parentModel = ParentTaskLoc::findOrFail($data['id']);
                $parentModel->update(['run_time' => Carbon::now()]);
            }else {
                // $childModel =  new ChildTaskLoc;
                // $resultUpdate = $childModel::where('id',$data['id'])->first()->updateOrFail(['run_time' => Carbon::now()]);   

                $childModel = ChildTaskLoc::findOrFail($data['id']);
                $childModel->update(['run_time' => Carbon::now()]);
            }

            return response()->json([
                'success' => true,
                'message' => 'Data updated successfully! id_update'.$data['id']
            ]);
          
        } catch (\Exception $e) { 
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong. Please try again.'
            ]);
        }
        // $parent = ParentModel::find($id);
        // $parent->update($request->all());
    }


    public function updateAllLoc(Request $request)
    {
        $data = $request->all();
        $success = [];
        $errors = [];

        foreach ($data as $id => $fields) {
            try {
                if ($fields['typeUpdate'] == 'parent') {
                    // $record = ParentTaskLoc::find($id);
                    $record = ParentTaskLoc::where('number_task', $id)->first();

                    if (!$record) {
                        $errors[] = "Record with ID {$id} not found.";
                        continue;
                    }

                    $record->status = $fields['status'];
                    $record->file_change = $fields['fileChange'];
                    $record->php = $fields['php'];
                    $record->js = $fields['js'];
                    $record->css = $fields['css'];
                    $record->tpl = $fields['tpl'];
                    $record->total = $fields['total'];
                    $record->branch = $fields['branch'];
                    $record->notes = $fields['notes'];
                    
                    if (!$record->save()) {
                        $errors[] = "Failed to update record with ID {$id}.";
                        continue;
                    }

                    $success[] = "Parent task with ID {$id} updated successfully.";
                } else {
                    // $record = ChildTaskLoc::find($id);
                    $record = ChildTaskLoc::where('number_task', $id)->first();

                    if (!$record) {
                        $errors[] = "Record with ID {$id} not found.";
                        continue;
                    }

                    // Cập nhật bản ghi
                    $record->status = $fields['status'];
                    $record->file_change = $fields['fileChange'];
                    $record->php = $fields['php'];
                    $record->js = $fields['js'];
                    $record->css = $fields['css'];
                    $record->tpl = $fields['tpl'];
                    $record->total = $fields['total'];
                    $record->branch = $fields['branch'];
                    $record->notes = $fields['notes'];

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
            'errors' => $errors,
        ]);
    }


    public function updateDataCSV(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:csv,txt|max:2048', // Kiểm tra định dạng file
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
     * Function temp -> update process after ver2
     */
    public function updateToTal($type)
    {
        $arrayParent = ParentTaskLoc::where('project_type', $type)->get();

        // Kiểm tra nếu mảng trống
        if ($arrayParent->isEmpty()) {
            return back()->withErrors('No records found for this project type.');
        }

        foreach ($arrayParent as $parent) {
            try {
                $childTasks = ChildTaskLoc::where('parent_id', $parent['id'])->get();

                // Khởi tạo biến để lưu tổng cộng dồn các giá trị
                $totalPhp = 0;
                $totalJs = 0;
                $totalCss = 0;
                $totalTpl = 0;
                $total = 0;

                foreach ($childTasks as $child) {
                    $totalPhp += $child->php ?? 0; // Cộng dồn giá trị cột php
                    $totalJs += $child->js ?? 0;   // Cộng dồn giá trị cột js
                    $totalCss += $child->css ?? 0; // Cộng dồn giá trị cột css
                    $totalTpl += $child->tpl ?? 0; // Cộng dồn giá trị cột tpl
                    $total += $child->total ?? 0; 
                }

                $parent->update([
                    'php' => $totalPhp,  // Cập nhật tổng giá trị php
                    'js' => $totalJs,    // Cập nhật tổng giá trị js
                    'css' => $totalCss,  // Cập nhật tổng giá trị css
                    'tpl' => $totalTpl,   // Cập nhật tổng giá trị tpl
                    'total'=>$total
                ]);
            } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
                // Nếu không tìm thấy bản ghi, tiếp tục với phần tử tiếp theo
                continue;
            } catch (\Exception $e) { 
                // Nếu có lỗi khác, dừng vòng lặp và trả về lỗi
                return response()->json([
                    'success' => false,
                    'message' => 'Something went wrong. Please try again.'
                ]);
            }
        }

        return response()->json([
            'success' => true,
            'message' => 'All records processed successfully.'
        ]);
    }

    
}
