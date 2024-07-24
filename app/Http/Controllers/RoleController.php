<?php

namespace App\Http\Controllers;

use App\Http\Requests\RoleRequest;
use App\Models\Role;
use App\Services\UserService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class RoleController extends Controller
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
        return $this->userService->getRoles();
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
    public function store(RoleRequest $request)
    {
        try {
            $this->userService->createRole($request->validated());
            return response(['message' => 'Role created successfully'], 201);
        } catch (\Exception) {
            return response()->json(['message' => 'An error occurred while creating the role'], 500);
        }
    }
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $this->userService->getRole($id);
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
    public function update(RoleRequest $request, Role $role)
    {
        try {
            $this->userService->updateRole($request->validated(), $role);
            return response()->json([
                'message' => "Role updated successfully",
            ],201);
        }
        catch (ModelNotFoundException){
            return response()->json(['message' =>'Role not found.'], 404);
        }
        catch (\Exception){
            return response()->json([ 'message' => 'An error occurred while updating the role' ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Role $role)
    {
        $this->userService->deleteRole($role);
        return response()->json([$role, 'message'=>'Role deleted successfully!'], 204);
    }
}
