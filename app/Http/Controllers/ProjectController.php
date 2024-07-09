<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProjectRequest;
use App\Models\Project;
use App\Services\ProjectService;
use http\Env\Response;
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
        catch (\Exception $e){
            return redirect()->back()->with('error', $e->getMessage());
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
            return \response()->json([
                'message' => "Project updated successfully",
            ]);
        }
        catch (\Exception $e){
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project)
    {
        $this->projectService->delete($project);
        return true;
    }
}
