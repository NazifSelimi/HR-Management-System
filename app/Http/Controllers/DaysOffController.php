<?php

namespace App\Http\Controllers;

use App\Http\Requests\DaysOffRequest;
use App\Models\DaysOff;
use App\Models\User;
use App\Services\DaysOffService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

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
            $this->daysOffService->store($request->validated());
            return response()->json(['message' => 'Request made successfully'], 201);
        } catch (\Exception $exception) {
            return response()->$exception->getMessage();
        }
    }

    public function update(Request $status, DaysOff $daysOff)
    {
        try {
            return $this->daysOffService->update($daysOff, $status->status);
        } catch (\Exception $exception) {
            return response()->$exception->getMessage();
        }
    }
}
