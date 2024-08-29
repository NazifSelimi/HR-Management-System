<?php

namespace App\Http\Controllers;

use App\Http\Requests\DaysOffRequest;
use App\Models\DaysOff;
use App\Models\User;
use App\Services\DaysOffService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use function Laravel\Prompts\error;

class DaysOffController extends Controller
{
    protected $daysOffService;

    public function __construct(DaysOffService $daysOffService)
    {
        $this->daysOffService = $daysOffService;
    }

    public function store(DaysOffRequest $request)
    {
        try {
            return $this->daysOffService->store($request->validated());
        } catch (\Exception $exception) {
            DB::rollBack();
            return response()->json(['error' => 'Something went wrong while requesting vacation'], 500);
        }
    }

    public function update(Request $status, DaysOff $daysOff)
    {
        try {
            return $this->daysOffService->update($daysOff, $status->status);
        } catch (\Exception $exception) {
            DB::rollBack();
            return response()->json(['error' => 'Something went wrong while reviewing vacation'], 500);
        }
    }
}
