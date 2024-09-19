<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use PHPUnit\Exception;

class UserController extends Controller
{
    protected $userService;

    public function __construct()
    {
        $this->userService = new UserService();
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //Get all users
        return $this->userService->getUsers();
    }

    public function getEmployees()
    {
        try {
            //Get only users that are employees
            return response()->json($this->userService->getEmployees());
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'No employees found.'], 404);
        } catch (\Exception) {
            return response()->json(['message' => 'Something went wrong.'], 500);
        }

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserRequest $request)
    {
        try {
            //Call create function to store a new user, returns the user created
            $this->userService->create($request->validated());
            return response()->json([
                'message' => "User created successfully",
            ], 201);
        } catch (\Exception) {
            return response()->json(['message' => 'An error occurred while creating the user'], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        try {
            //Show one user, returns selected user
            return $this->userService->getUserById($user->id);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'User not found'], 404);
        } catch (\Exception) {
            return response()->json(['message' => 'Something went wrong while fetching user'], 500);
        }

    }

    public function assignDepartments(User $user, Request $request)
    {
        //Expect and input of and array of objects that consists of a department id and a position
        $request->validate([
            'departments' => 'required|array',
            'departments.*.id' => 'exists:departments,id',
            'departments.*.position' => 'required|string',
        ]);

        //Stores the validated departments with positions in the pivot table
        $this->userService->assignDepartments($user, $request);
        return response()->json([
            'message' => 'Departments assigned successfully',
            'user' => $user->load('departments')
        ]);
    }

    public function assignProjects(User $user, Request $request)
    {
        //Expect and input of and array of objects that consists of a project id and a role
        $request->validate([
            'projects' => 'required|array',
            'projects.*.id' => 'exists:projects,id',
            'projects.*.role' => 'required|string',
        ]);

        //Stores the validated projects with roles in the pivot table
        $this->userService->assignProjects($user, $request);
        return response()->json([
            'message' => 'Projects assigned successfully',
            'user' => $user->load('projects')
        ]);
    }

    //Ask veton, pass a model Project $project and return $project
    // or keep it like this since we already have teh get users function?


    /**
     * Update the specified resource in storage.
     */
    public function update(UserRequest $request, User $user)
    {
        try {
            //Updates user record with new data
            $this->userService->updateUser($request->validated(), $user);
            return response(['message' => 'User updated successfully'], 201);
        } catch (ModelNotFoundException) {
            return response()->json(['message' => 'User not found.'], 404);
        } catch (\Exception) {
            return response()->json(['message' => 'An error occurred while updating the user'], 500);
        }

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        try {
            //Deletes user record
            $this->userService->deleteUser($user);
            return response()->json([$user, 'message' => 'User deleted successfully !'], 204);
        } catch (ModelNotFoundException) {
            return response()->json(['message' => 'User not found.'], 404);
        } catch (\Exception) {
            return response()->json(['message' => 'An error occurred while deleting the user'], 500);
        }

    }
}
