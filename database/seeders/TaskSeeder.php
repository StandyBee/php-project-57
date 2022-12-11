<?php

namespace Database\Seeders;

use App\Models\Task;
use App\Models\TaskStatus;
use App\Models\User;
use Illuminate\Database\Seeder;

class TaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (Task::where('name', 'newTask')->first() == null) {
            Task::create([
                'name' => 'newTask',
                'status_id' => TaskStatus::first()->id,
                'created_by_id' => User::first()->id
            ]);
        }
    }
}
