<?php

namespace App\Http\Controllers;

use App\Http\Requests\DepartmentRequest;
use App\Models\Department;
use App\Services\DepartmentService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    protected $departmentService;

    public function __construct()
    {
        $this->departmentService = new DepartmentService();
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return $this->departmentService->getDepartments();
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
    public function store(DepartmentRequest $request)
    {
        try {
            $this->departmentService->create($request->validated());
            return response()->json([
                'message' => "Department created successfully",
            ], 201);
        } catch (\Exception) {
            return response()->json(['message' => 'An error occurred while creating the department'], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Department $department)
    {
        return $this->departmentService->getDepartmentById($department->id);
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
    public function update(DepartmentRequest $request, Department $department)
    {
        try {
            $this->departmentService->update($request->validated(), $department);
            return response(['message' => 'Department updated successfully'], 201);
        } catch (ModelNotFoundException) {
            return response()->json(['message' => 'Department not found.'], 404);
        } catch (\Exception) {
            return response()->json(['message' => 'An error occurred while updating the department'], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Department $department)
    {
        $this->departmentService->delete($department);
        return response()->json([$department, 'message' => 'User deleted successfully !'], 204);
    }
}
