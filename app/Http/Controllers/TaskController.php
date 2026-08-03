<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Http\Resources\TaskResource;
use App\Models\Task;
use App\Services\TaskService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class TaskController extends Controller
{
    public function __construct(
        private readonly TaskService $taskService,
    ) {
    }

    public function index(Request $request): AnonymousResourceCollection
    {
        $filters = $request->only(['status', 'priority', 'title']);
        $tasks = $this->taskService->getPaginatedForUser($request->user(), $filters);

        return TaskResource::collection($tasks);
    }

    public function store(StoreTaskRequest $request): TaskResource
    {
        $task = $this->taskService->create($request->validated());

        return new TaskResource($task);
    }

    public function show(Request $request, Task $task): TaskResource
    {
        $this->authorizeTask($request, $task);

        return new TaskResource($task);
    }

    public function update(UpdateTaskRequest $request, Task $task): TaskResource
    {
        $this->authorizeTask($request, $task);

        $task = $this->taskService->update($task, $request->validated());

        return new TaskResource($task);
    }

    public function destroy(Request $request, Task $task): JsonResponse
    {
        $this->authorizeTask($request, $task);

        $this->taskService->delete($task);

        return response()->json(null, 204);
    }

    private function authorizeTask(Request $request, Task $task): void
    {
        if ($task->project?->user_id !== $request->user()->id) {
            abort(403, 'Unauthorized action.');
        }
    }
}
