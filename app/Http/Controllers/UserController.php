<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use mysql_xdevapi\Exception;

class UserController extends Controller
{
    protected $userService;

    public function __construct(){
        $this->userService = new UserService();
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return $this->userService->getEmployees();
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
    public function store(UserRequest $request)
    {
        try{
           $this->userService->create($request->validated());
            return response()->json([
                'message' => "User created successfully",
            ],201);
        }
        catch (\Exception){
            return response()->json([ 'message' => 'An error occurred while creating the user' ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $this->userService->getUser($id);
    }

    //Ask veton, pass a model Project $project and return $project
    // or keep it like this since we already have teh get users function?

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
    public function update(UserRequest $request, User $user)
    {
        try{
            $this->userService->updateUser($request->validated() ,$user);
            return response(['message' => 'User updated successfully'], 201);
        }catch (ModelNotFoundException){
            return response()->json(['message' =>'User not found.'], 404);
        }
        catch (\Exception){
            return response()->json([ 'message' => 'An error occurred while updating the user' ], 500);
        }

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $this->userService->deleteUser($user);
        return response()->json([$user, 'message'=>'User deleted successfully !'], 204);
    }
}
