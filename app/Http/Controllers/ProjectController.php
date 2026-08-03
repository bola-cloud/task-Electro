<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\StoreProjectRequest;
use App\Http\Requests\UpdateProjectRequest;
use App\Http\Resources\ProjectResource;
use App\Models\Project;
use App\Services\ProjectService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ProjectController extends Controller
{
    public function __construct(
        private readonly ProjectService $projectService,
    ) {
    }

    public function index(Request $request): AnonymousResourceCollection
    {
        $projects = $this->projectService->getPaginatedForUser($request->user());

        return ProjectResource::collection($projects);
    }

    public function store(StoreProjectRequest $request): ProjectResource
    {
        $project = $this->projectService->createForUser($request->user(), $request->validated());

        return new ProjectResource($project);
    }

    public function show(Request $request, Project $project): ProjectResource
    {
        if ($project->user_id !== $request->user()->id) {
            abort(403, 'Unauthorized action.');
        }

        return new ProjectResource($project);
    }

    public function update(UpdateProjectRequest $request, Project $project): ProjectResource
    {
        if ($project->user_id !== $request->user()->id) {
            abort(403, 'Unauthorized action.');
        }

        $project = $this->projectService->update($project, $request->validated());

        return new ProjectResource($project);
    }

    public function destroy(Request $request, Project $project): JsonResponse
    {
        if ($project->user_id !== $request->user()->id) {
            abort(403, 'Unauthorized action.');
        }

        $this->projectService->delete($project);

        return response()->json(null, 204);
    }
}
