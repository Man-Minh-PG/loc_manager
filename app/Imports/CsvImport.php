<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow; // If file CSV has header

use App\Models\ParentTaskLoc;
use App\Models\ChildTaskLoc;

class CsvImport implements ToCollection, WithHeadingRow
{
    /**
    * Reading csv - insert data into db 
    * @param Collection $collection
    */
    public function collection(Collection $collection)
    {
        foreach ($collection as $row) {
            // Tạo hoặc tìm parentTask
            $parent = ParentTaskLoc::firstOrCreate(
                ['id' => $row['parenttask']],
                [
                    'source_type' => $row['sourcetype'],
                    'file_change' => $row['filechange'],
                    'php'         => $row['php'],
                    'js'          => $row['js'],
                    'css'         => $row['css'],
                    'tpl'         => $row['tpl'],
                    'total'       => $row['total'],
                    'branch'      => $row['branch'],
                    'notes'       => $row['notes'],
                    'path'        => $row['path'],
                ]
            );

            // if parent task has child task
            if (!empty($row['childtask'])) {
                ChildTaskLoc::create([
                    'parent_task_loc_id' => $parent->id,
                    'id'                 => $row['childtask'],
                    'source_type'        => $row['sourcetype'],
                    'file_change'        => $row['filechange'],
                    'php'                => $row['php'],
                    'js'                 => $row['js'],
                    'css'                => $row['css'],
                    'tpl'                => $row['tpl'],
                    'total'              => $row['total'],
                    'branch'             => $row['branch'],
                    'notes'              => $row['notes'],
                    'path'               => $row['path'],
                ]);
            }
        }
    }
}
