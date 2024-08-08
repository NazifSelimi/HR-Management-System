<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProjectRequest;
use App\Services\ProjectService; // Ensure correct namespace
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
        return $project;
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
        try{
            $this->projectService->update($request->validated(), $project);
            return response()->json([
                'message' => "Project updated successfully",
            ],201);
        }
        catch (ModelNotFoundException){
            return response()->json(['message' =>'Project not found.'], 404);
        }
        catch (\Exception){
            return response()->json([ 'message' => 'An error occurred while updating the project' ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project)
    {
        $this->projectService->delete($project);
        return response()->json([$project, 'message'=>'Project deleted successfully!'], 204);
    }
}
