<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\ParentTaskLoc;
use App\Models\ChildTaskLoc;

class ChildTaskLocFactory extends Factory
{
    protected $model = ChildTaskLoc::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
           'parent_id'    => ParentTaskLoc::factory(),
           'number_task'  => $this->faker->randomNumber(7, true),
           'project_type' => $this->faker->randomElement([1,2]), 
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
           'path'         => "D://"
        ];
    }
}
