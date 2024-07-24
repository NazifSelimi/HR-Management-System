<?php

namespace App\Http\Controllers;

use App\Http\Requests\VacationRequest;
use App\Models\DaysOff;
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
       return $this->vacationService->requestVacation($request->validated());
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
    public function update(VacationRequest $request, DaysOff $vacation)
    {
        try {
            $this->vacationService->updateVacation($request->validated(),$vacation);
            return response()->json($vacation, 200);
        }
        catch (ModelNotFoundException $e){
            return response()->json(['message' =>'DaysOff not found.'], 404);
        }

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DaysOff $vacation)
    {
        $this->vacationService->deleteVacation($vacation);
        return response()->json([$vacation, 'message'=>'DaysOff deleted successfully !'], 200);

    }
}
