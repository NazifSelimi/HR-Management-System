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
        //Get all project records
        return $this->projectService->getProjects();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProjectRequest $request): JsonResponse
    {
        try {
            //Create and store new project record
            $this->projectService->create($request->validated());
            return response()->json(['message' => 'Project created successfully'], Response::HTTP_CREATED);
        } catch (\Throwable $e) {
            return response()->json(['message' => 'An error occurred while creating the project'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Project $project)
    {
        //Returns specific project by id
        try {
            return $this->projectService->getProjectById($project->id);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Project not found'], 404);
        } catch (\Exception) {
            return \response()->json(['message' => 'Somethin went wrong while fetching the project'], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProjectRequest $request, Project $project)
    {
        try {
            //Update existing project record
            $updatedProject = $this->projectService->update($request->validated(), $project);
            return response()->json([
                'message' => "Project updated successfully",
                'project' => $updatedProject
            ], Response::HTTP_OK);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Project not found.'], Response::HTTP_NOT_FOUND);
        } catch (\Throwable $e) {
            return response()->json(['message' => 'An error occurred while updating the project'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project)
    {
        try {
            //Delete existing project record
            $this->projectService->delete($project);
            return response()->json([$project, 'message' => 'Project deleted successfully!'], 204);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Project not found.'], Response::HTTP_NOT_FOUND);
        } catch (\Exception $e) {
            return \response()->json(['message' => 'Something went wrong.'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

    }
}
