<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileRequest;
use App\Http\Requests\UserRequest;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
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
            $data = $request->validated();
            $data['password'] = Hash::make('password');
            //Call create function to store a new user, returns the user created
            $this->userService->create($data);
            return response()->json([
                'message' => "User created successfully.",
            ], 201);
        } catch (\Exception $e) {
            return response()->json(['error' => "Something went wrong while trying to create user."], 500);
        }
    }

    public function updatePassword(Request $request)
    {
        $user = $request->user();

        // Check if the user is required to change their password
        if (!$user->must_change_password) {
            return response()->json(['message' => 'Password change not required'], 400);
        }

        // Validate the new password
        $request->validate([
            'password' => ['required', 'confirmed', 'min:8'],
        ]);

        $this->userService->updatePassword($user, $request->password);

        return response()->json(['message' => 'Password updated successfully']);
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

    public function removeFromProject(User $user, Request $request)
    {
        // Call the service method to remove projects
        $response = $this->userService->removeFromProject($user, $request->projects);

        return response()->json($response);
    }

    public function removeFromDepartment(User $user, Request $request)
    {
        // Call the service method to remove departments
        $response = $this->userService->removeFromDepartment($user, $request->departments);

        return response()->json($response);
    }

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

    public function updateProfile(ProfileRequest $request, User $user)
    {
        try {
            //Updates user record with new data
            $this->userService->updateUser($request->validated(), $user);
            return response(['message' => 'User updated successfully'], 201);
        } catch (ModelNotFoundException) {
            return response()->json(['message' => 'User not found.'], 404);
        } catch (\Exception $e) {
            return response()->json(['error' => 'An error occurred while updating the user'], 500);
            //return response()->json(['exception' => $e->getMessage()], 500);
        }
    }

    public function profile()
    {
        return Auth::user();
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
