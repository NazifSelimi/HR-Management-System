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
        $this->userService->getUser($id);
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
    public function update(UserRequest $request, User $user)
    {
        try{
            $this->userService->updateUser($request->validated() ,$user);
            return response()->json($user, 200);
        }catch (ModelNotFoundException $e){
            return response()->json(['message' =>'User not found.'], 404);
        }
        catch (\Exception $e){
            return response()->json([ 'message' => 'An error occurred while updating the user' ], 500);
        }

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $this->userService->deleteUser($user);
        return response()->json([$user, 'message'=>'User deleted successfully !'], 200);
    }
}
