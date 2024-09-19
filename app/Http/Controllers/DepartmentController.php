<?php

namespace App\Http\Controllers;

use App\Http\Requests\DepartmentRequest;
use App\Models\Department;
use App\Models\Project;
use App\Services\DepartmentService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        //Get all department records
        return $this->departmentService->getDepartments();
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(DepartmentRequest $request)
    {
        try {
            //Call function to create and store a new department record
            $this->departmentService->create($request->validated());
            return response()->json([
                'message' => "Department created successfully",
            ], 201);
        } catch (\Exception) {
            return response()->json(['message' => 'An error occurred while creating the department'], 500);
        }
    }

    public function assignUsers(Request $request, Department $department)
    {
        //Expect and input of and array of objects that consists of a user id and a position
        $request->validate([
            'users' => 'required|array',
            'users.*.id' => 'exists:users,id',
            'users.*.position' => 'required|string',
        ]);

        //Stores the validated users with positions in the pivot table
        return $this->departmentService->assignUsers($department, $request);
//        return response()->json([
//            'message' => 'Users and positions assigned successfully',
//            'department' => $department->load('users') // Load the users relationship
//        ]);

    }
    public function updateUserPosition(Department $department, Request $request)
    {
        // Validate the incoming request
        $request->validate([
            'users' => 'required|array',
            'users.*.id' => 'required|integer|exists:users,id',
            'users.*.position' => 'required|string|max:255',
        ]);

        // Call the service to update the user roles
        $response = $this->departmentService->updateUserPosition($department, $request->users);

        // Return the response
        return response()->json($response);
    }

//    public function updateUserPosition($departmentId, Request $request)
//    {
//        // Fetch the department manually
//        $department = Department::find($departmentId);
//
//        // Check if the department was found
//        if (!$department) {
//            return response()->json(['message' => 'Department not found'], 404);
//        }
//
//        // Validate the incoming request
//        $request->validate([
//            'users' => 'required|array',
//            'users.*.id' => 'required|integer|exists:users,id',
//            'users.*.position' => 'required|string|max:255',
//        ]);
//
//        // Call the service to update the user roles
//        $response = $this->departmentService->updateUserPosition($department, $request->users);
//
//        // Return the response
//        return response()->json($response);
//    }


    public function getEmployeeDepartments()
    {
        try {
            $projects = $this->departmentService->getEmployeeDepartments(Auth::id());

            return response()->json($projects, 200); // Directly return the projects
        } catch (\Exception $e) {
            return response()->json(['message' => 'Server error occurred.'], 500);
        }
    }

    public function getEmployeeDepartmentsById(Department $department)
    {
        if ($department->users->contains(Auth::id())) {
            return $this->departmentService->getEmployeeDepartmentsById($department->id);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Department $department)
    {
        //Show one department, returns selected department
        return $this->departmentService->getDepartmentById($department->id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(DepartmentRequest $request, Department $department)
    {
        try {
            //Update department record with new data
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
        try {
            //Delete department record
            $this->departmentService->delete($department);
            return response()->json([$department, 'message' => 'User deleted successfully !'], 204);
        } catch (ModelNotFoundException) {
            return response()->json(['message' => 'Department not found.'], 404);
        } catch (\Exception) {
            return response()->json(['message' => 'An error occurred while deleting the department'], 500);
        }

    }
}
