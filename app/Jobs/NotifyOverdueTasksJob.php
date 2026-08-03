<?php

declare(strict_types=1);

namespace App\Jobs;

use App\Models\Task;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Log;

class NotifyOverdueTasksJob implements ShouldQueue
{
    use Queueable;

    public function __construct()
    {
    }

    public function handle(): void
    {
        $overdueTasks = Task::where('due_date', '<', now())
            ->where('status', '!=', 'done')
            ->get();

        foreach ($overdueTasks as $task) {
            Log::info("Task [{$task->id}] is overdue!");
        }
    }
}
