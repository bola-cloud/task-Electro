<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $user = User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        $projects = Project::factory(5)->create([
            'user_id' => $user->id,
        ]);

        foreach ($projects as $project) {
            Task::factory(10)->create([
                'project_id' => $project->id,
            ]);
        }
    }
}
