<?php

namespace App\Http\Controllers;

use App\Http\Requests\PositionRequest;
use App\Models\Position;
use App\Services\PositionService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class PositionController extends Controller
{
    protected $positionService;

    public function __construct(PositionService $positionService)
    {
        $this->positionService = $positionService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return $this->positionService->getPositions();
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
    public function store(PositionRequest $request)
    {
        try{
            $this->positionService->create($request->validated());
            return \response()->json([
                'message' => "Position created successfully",
            ],201);
        }
        catch (\Exception){
            return response()->json([ 'message' => 'An error occurred while creating the position' ], 500);
        }

    }

    /**
     * Display the specified resource.
     */
    public function show(Position $position)
    {
        return $position;
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
    public function update(PositionRequest $request, Position $position)
    {
        try{
            $this->positionService->update($request->validated(), $position);
            return \response()->json([
                'message' => "Position updated successfully",
            ],201);
        }
        catch (ModelNotFoundException){
            return response()->json(['message' =>'Position not found.'], 404);
        }
        catch (\Exception){
            return response()->json([ 'message' => 'An error occurred while updating the position' ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Position $position)
    {
        $this->positionService->delete($position);
        return response()->json([$position, 'message'=>'Position deleted successfully !'], 204);
    }
}
