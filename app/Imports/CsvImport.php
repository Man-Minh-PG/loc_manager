<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow; // If file CSV has header

use App\Models\ParentTaskLoc;
use App\Models\ChildTaskLoc;
use App\Models\IndexKey;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class CsvImport implements ToCollection, WithHeadingRow
{
    /**
     * example D:\linesOfCode\2024\December\PW_12_1
     */
    const PATH_SAVE_FILE = "D:\linesOfCode";

    /**
    * Reading csv - insert data into db 
    * @param Collection $collection
    */
    public function collection(Collection $collection)
    {
        if(isset($collection[0]['is_parent'])){
            CsvImport::csvUpdateData($collection);
            return;
        }

        $projectName = $collection[0]['project_type'] == config('common.PW') ? "PW" : "BEER";
        $index       = 1;
        $month       = Carbon::now()->month;
        $tempId      = 0; // Fix insert duplication
        
        $key = $projectName.'_'.$month.'_'.$index;//"pw_11_01"
        
        $valueIndexKey = IndexKey::where('key_value', $key)->first();

        // set index
        if(is_null($valueIndexKey)) {
            $valueIndexKey = $key;
        }else {
            $lastIndex = substr($valueIndexKey['key_value'], -1, 2);
    
            $key           = $projectName.'_'.$month.'_'.intval($lastIndex) + $index;
            $valueIndexKey = $key;
            unset($key);
        }

        DB::beginTransaction();

        try{
            // inssert key into db
            $idKey = IndexKey::create([
                'key_value' => $valueIndexKey
            ]);
       
            foreach ($collection as $row) {
                // Tạo hoặc tìm parentTask
                // $parent = ParentTaskLoc::firstOrCreate(
                //     ['id' => $row['parenttask']],
                //     [
                //         'index_key_id'=> $idKey,
                //         'project_type'=> $row['project_type'],
                //         'source_type' => $row['sourcetype'],
                //         'file_change' => $row['filechange'],
                //         'php'         => $row['php'],
                //         'js'          => $row['js'],
                //         'css'         => $row['css'],
                //         'tpl'         => $row['tpl'],
                //         'total'       => $row['total'],
                //         'branch'      => $row['branch'],
                //         'notes'       => $row['notes'],
                //         'path'        => $row['path'],
                //     ]
                // );

                if($tempId != $row['parent_task']) {
                        $parent = ParentTaskLoc::create([
                            'index_key_id' => $idKey['id'], // syntax 2
                            'project_type' => $row['project_type'],
                            'number_task'  => $row['parent_task'],
                            'status'       => $row['status'] ?? 1,
                            'source_type'  => $row['source_type'],
                            'file_change'  => $row['file_change'] ?? 0,
                            'php'          => $row['php'] ?? 0,
                            'js'           => $row['js'] ?? 0,
                            'css'          => $row['css'] ?? 0,
                            'tpl'          => $row['tpl'] ?? 0,
                            'total'        => $row['total'] ?? 0,
                            'branch'       => $row['branch'] ?? 'temp',
                            'notes'        => $row['notes'] ?? 'temp',
                            'path'         => CsvImport::processPath($month, $valueIndexKey, $row['parent_task'], $row['source_type']),
                        ]
                    );
                }
                
                $tempId = $row['parent_task'];

                // if parent task has child task
                if (!empty($row['child_task'])) {
                    ChildTaskLoc::create([ 
                        'parent_id'    => $parent->id, // syntax 1
                        'number_task'  => $row['child_task'],
                        'project_type' => $row['project_type'],
                        'status'       => $row['status'] ?? 1,
                        'source_type'  => $row['source_type'],
                        'file_change'  => $row['file_change'] ?? 0,
                        'php'          => $row['php'] ?? 0,
                        'js'           => $row['js'] ?? 0,
                        'css'          => $row['css'] ?? 0,
                        'tpl'          => $row['tpl'] ?? 0,
                        'total'        => $row['total'] ?? 0,
                        'branch'       => $row['branch'] ?? 'temp',
                        'notes'        => $row['notes'] ?? 'temp',
                        'path'         => CsvImport::processPath($month, $valueIndexKey, $row['child_task'], $row['source_type']),
                    ]);
                }

                DB::commit();

            }
        } catch (\Exception $e) { 
            DB::rollBack();
            \Log::error('Error occurred: ' . $e->getMessage());
            return response()->json(['error' => 'Something went wrong, please try again later.'], 500);
        }
    }


    /**
     * HOT FIX PROCESS FOR PW
     */
    public function csvUpdateData(Collection $collection) {
        // $projectName = "PW";
        // $index       = 1;
        // $month       = Carbon::now()->month;
        // $tempId      = 0; // Fix insert duplication
        // $errors      = [];
        // $success = [];
        
        // $key = $projectName.'_'.$month.'_'.$index;//"pw_11_01"
        
        // $valueIndexKey = IndexKey::where('key_value', $key)->first();

        // // set index
        // if(is_null($valueIndexKey)) {
        //     $valueIndexKey = $key;
        // }else {
        //     $lastIndex = substr($valueIndexKey['key_value'], -1, 2);
    
        //     $key           = $projectName.'_'.$month.'_'.intval($lastIndex) + $index;
        //     $valueIndexKey = $key;
        //     unset($key);
        // }

        DB::beginTransaction();

        try {
            foreach ($collection as $row) { 

                if($row['is_parent'] == 1) {
                    $fileChange = $row['file_change'];
                    $php = $row['php'];
                    $js = $row['js'];
                    $css = $row['css'];
                    $tpl = $row['tpl'];
                    $total = $row['total'];
                    
                    $parent = ParentTaskLoc::where('number_task', $row['task'])->update([
                        'file_change' => $fileChange,
                        'php' => $php,
                        'js' => $js,
                        'css'=> $css,
                        'tpl' => $tpl,
                        'total' => $total
                    ]);

                } else {

                    $fileChange = $row['file_change'];
                    $php = $row['php'];
                    $js = $row['js'];
                    $css = $row['css'];
                    $tpl = $row['tpl'];
                    $total = $row['total'];
                    
                    $updated = ChildTaskLoc::where('number_task', $row['task'])->update([
                        'file_change' => $fileChange,
                        'php' => $php,
                        'js' => $js,
                        'css' => $css,
                        'tpl' => $tpl,
                        'total' => $total,
                    ]);
                
                    $task = $row['task'];
                    if ($updated === 0) {
                        $errors[] = "Không tìm thấy bản ghi với task: $task ";
                        continue; // Bỏ qua dòng này, chuyển sang dòng tiếp theo
                    }

                    
                }
               
            } 
            // $success[] = "Parent task with ID {$id} updated successfully.";

            // return response()->json([
            //     'success' => true,
            //     'message' => $success,
            // ]);
            DB::commit();

            // Bạn có thể trả về một phản hồi hoặc làm gì đó ở đây sau khi commit thành công.
            return response()->json(['success' => true, 'message' => 'Records updated successfully.']);
        }catch (\Exception $e) { 
            DB::rollBack();
            \Log::error('Error occurred: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong, please try again later.',
                'error_detail' => $e->getMessage() // Nếu cần hiển thị chi tiết lỗi (tùy theo yêu cầu)
            ], 500);
        }
    }

    private function processPath($month, $valueIndexKey, $numberTask, $sourceType){
        $year         = Carbon::now()->year;
        $lstMonthName = config('months');
        $monthName    = $lstMonthName[$month];
        $typeName     = $sourceType == config("common.Sys") ? 'sys' : 'ec';

        return CsvImport::PATH_SAVE_FILE . "\\" . $year . "\\" . $monthName . "\\" . $valueIndexKey . "\\" . $numberTask. '_' .$typeName. '_compare.xlsx';
    }
}
