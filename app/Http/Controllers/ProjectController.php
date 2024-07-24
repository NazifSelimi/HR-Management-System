<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProjectRequest;
use App\Models\Project;
use App\Services\ProjectService;
use http\Env\Response;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

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
    public function store(ProjectRequest $request)
    {
        try{
            $this->projectService->create($request->validated());
            return response(['message' => 'Project created successfully'], 201);
        }
        catch (\Exception){
            return response()->json([ 'message' => 'An error occurred while creating the position' ], 500);
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
