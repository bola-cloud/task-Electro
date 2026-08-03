<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Task;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $userId = $request->user()->id;

        $totalProjects = Project::where('user_id', $userId)->count();
        $activeProjects = Project::where('user_id', $userId)->where('status', 'active')->count();

        $baseTaskQuery = Task::whereHas('project', function (Builder $query) use ($userId) {
            $query->where('user_id', $userId);
        });

        $totalTasks = (clone $baseTaskQuery)->count();
        $completedTasks = (clone $baseTaskQuery)->where('status', 'done')->count();
        $pendingTasks = (clone $baseTaskQuery)->whereIn('status', ['todo', 'in_progress'])->count();
        $overdueTasks = (clone $baseTaskQuery)->where('due_date', '<', now())->where('status', '!=', 'done')->count();

        return response()->json([
            'total_projects' => $totalProjects,
            'active_projects' => $activeProjects,
            'total_tasks' => $totalTasks,
            'completed_tasks' => $completedTasks,
            'pending_tasks' => $pendingTasks,
            'overdue_tasks' => $overdueTasks,
        ]);
    }
}
