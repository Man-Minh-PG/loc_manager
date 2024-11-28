<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\IndexKey;

class IndexKeyFactory extends Factory
{
    protected $model = IndexKey::class;
    
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'key_value' =>  $this->faker->randomNumber(4, true)
        ];
    }
}
