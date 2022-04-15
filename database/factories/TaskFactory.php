<?php

namespace Database\Factories;

use App\Models\Task;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\DB;

class TaskFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $users = DB::table('users')->get(['id']);
        return [
            'name' => $this->faker->text(30),
            'description' => $this->faker->text(),
            'status' => collect(Task::STATUSES)->random(),
            'user_id' => $users->random()->id,
        ];
    }
}
