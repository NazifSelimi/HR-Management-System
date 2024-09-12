<?php

namespace App\Http\Controllers;

use App\Http\Requests\DaysOffRequest;
use App\Models\DaysOff;
use App\Models\User;
use App\Services\DaysOffService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use function Laravel\Prompts\error;

class DaysOffController extends Controller
{
    protected $daysOffService;

    public function __construct(DaysOffService $daysOffService)
    {
        $this->daysOffService = $daysOffService;
    }

    public function index()
    {
        return $this->daysOffService->get();
    }

    public function getEmployeeDaysOff()
    {
        return $this->daysOffService->getEmployeeDaysOff(Auth::id());
    }

    public function store(DaysOffRequest $request)
    {
        try {
            $userId = Auth::user();
            //Calls a store function when user requests a vacation; Returns a json message;
            return $this->daysOffService->store($request->validated(), $userId);

            //Catch any unhandled errors
        } catch (\Exception $exception) {
            return response()->json(['error' => 'Something went wrong while requesting vacation'], 500);
        }
    }

    public function update(Request $status, DaysOff $daysOff)
    {
        try {
            //Calls update function on vacation request; Returns json message for accepting and rejecting vacation
            return $this->daysOffService->update($daysOff, $status['status']);

            //Catch any unhandled errors; Rollback the database if there's any data inconsistency;
        } catch (\Exception $exception) {
            DB::rollBack();
            return response()->json(['error' => 'Something went wrong while reviewing vacation'], 500);
        }
    }
}
