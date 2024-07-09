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
            $role = $this->userService->createRole($request->validated());
            return response()->json([$role, 'message'=>'Role Created successfully !'], 200);
        }
        catch (\Exception $e){
            return redirect()->back()->with('error', $e->getMessage());
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

        }catch (ModelNotFoundException $e){
            return response()->json(['message' =>'Role not found.'], 404);
        }
        catch (\Exception $e){
            return response()->json([ 'message' => 'An error occurred while updating the Role' ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Role $role)
    {
        $this->userService->deleteRole($role);
        return response()->json([$role, 'message'=>'Role deleted successfully !'], 200);

    }
}
