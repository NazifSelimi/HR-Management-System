<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProjectRequest;
use App\Models\Project;
use App\Services\ProjectService;

// Ensure correct namespace
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class ProjectController extends Controller
{

    protected $projectService;

    public function __construct()
    {
        $this->projectService = new ProjectService();
    }

    public function index()
    {
        return $this->projectService->getProjects();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProjectRequest $request): JsonResponse
    {
        try {
            $this->projectService->create($request->validated());
            return response()->json(['message' => 'Project created successfully'], Response::HTTP_CREATED);
        } catch (\Throwable $e) {
            // Log the exception message for debugging
            \Log::error('Project creation failed: ' . $e->getMessage());

            return response()->json(['message' => 'An error occurred while creating the project'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Project $project)
    {
        return $this->projectService->getProjectById($project->id);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProjectRequest $request, Project $project)
    {
        try {
            $updatedProject = $this->projectService->update($request->validated(), $project);
            return response()->json([
                'message' => "Project updated successfully",
                'project' => $updatedProject
            ], Response::HTTP_OK); // Use 200 for successful updates
        } catch (ModelNotFoundException $e) {

            return response()->json(['message' => 'Project not found.'], Response::HTTP_NOT_FOUND);
        } catch (\Throwable $e) {
            // Log exception
            \Log::error('Error updating project: ' . $e->getMessage());

            return response()->json(['message' => 'An error occurred while updating the project'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project)
    {
        $this->projectService->delete($project);
        return response()->json([$project, 'message' => 'Project deleted successfully!'], 204);
    }
}
