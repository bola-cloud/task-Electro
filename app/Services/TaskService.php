<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;

class TaskService
{
    public function getPaginatedForUser(User $user, array $filters, int $perPage = 15): LengthAwarePaginator
    {
        return Task::whereHas('project', function (Builder $query) use ($user) {
                $query->where('user_id', $user->id);
            })
            ->when($filters['status'] ?? null, function (Builder $query, string $status) {
                $query->where('status', $status);
            })
            ->when($filters['priority'] ?? null, function (Builder $query, string $priority) {
                $query->where('priority', $priority);
            })
            ->when($filters['title'] ?? null, function (Builder $query, string $title) {
                $query->where('title', 'like', "%{$title}%");
            })
            ->latest()
            ->paginate($perPage);
    }

    public function create(array $data): Task
    {
        return Task::create($data);
    }

    public function update(Task $task, array $data): Task
    {
        $task->update($data);

        return $task;
    }

    public function delete(Task $task): void
    {
        $task->delete();
    }
}
