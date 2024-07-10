<?php

namespace App\Http\Controllers;

use App\Http\Requests\VacationRequest;
use App\Models\Vacation;
use App\Services\VacationService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class VacationController extends Controller
{

    protected $vacationService;

    public function __construct(){
        $this->vacationService = new VacationService();
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return $this->vacationService->getVacations();
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
    public function store(VacationRequest $request)
    {
        try{
            $this->vacationService->requestVacation($request->validated());
            return response(['message' => 'Vacation requested successfully'], 201);
        }
        catch (\Exception){
            return response()->json([ 'message' => 'An error occurred while requesting the position' ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return $this->vacationService->getVacation($id);
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
    public function update(VacationRequest $request, Vacation $vacation)
    {
        try {
            $this->vacationService->updateVacation($request->validated(),$vacation);
            return response()->json([
                'message' => "Vacation updated successfully",
            ],201);
        }
        catch (ModelNotFoundException){
            return response()->json(['message' =>'Vacation not found.'], 404);
        }
        catch (\Exception){
            return response()->json([ 'message' => 'An error occurred while updating the vacation' ], 500);
        }

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Vacation $vacation)
    {
        $this->vacationService->deleteVacation($vacation);
        return response()->json([$vacation, 'message'=>'Vacation deleted successfully!'], 204);
    }
}
