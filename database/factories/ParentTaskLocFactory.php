<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\ParentTaskLoc;
use App\Models\IndexKey;

class ParentTaskLocFactory extends Factory
{
     // Định nghĩa mô hình mà Factory này sẽ tạo dữ liệu cho
     protected $model = ParentTaskLoc::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
           'index_key_id' => IndexKey::factory(), 
           'project_type' => $this->faker->randomElement([1, 2]), 
           'number_task'  => $this->faker->randomNumber(7, true), 
           'status'       => $this->faker->randomElement([1,2]),
           'source_type'  => $this->faker->randomElement([1,2]),
           'file_change'  => $this->faker->randomElement([16, 88, 99, 43, 55, 66, 77, 88]),
           'php'          => $this->faker->randomElement([16, 88, 99, 43, 55, 66, 77, 88]),
           'js'           => $this->faker->randomElement([16, 88, 99, 43, 55, 66, 77, 88]),    
           'css'          => $this->faker->randomElement([16, 88, 99, 43, 55, 66, 77, 88]),
           'tpl'          => $this->faker->randomElement([16, 88, 99, 43, 55, 66, 77, 88]),
           'total'        => $this->faker->randomElement([16, 88, 99, 43, 55, 66, 77, 88]),
           'branch'       => $this->faker->domainName,
           'notes'        => $this->faker->company,
        //    'remember_token' => Str::random(10), 
        //    'created_at' => now(), // Thời gian tạo bản ghi
        //    'updated_at' => now(), // Thời gian cập nhật bản ghi
        ];
    }
}
