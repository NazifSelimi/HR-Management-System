<?php

namespace App\Services;


use App\Models\DaysOff;

class VacationService
{
    public function getVacations()
    {
        return DaysOff::all();

    }

    public function getVacation(string $id)
    {
        return DaysOff::query()->where('id', $id)->first();
    }
    public function getVacationsByUser(string $userId)
    {
        return DaysOff::query()->where('user_id', $userId)->get();
    }

    public function updateVacation($data, $vacation)
    {
        $vacation->update($data);
        return $vacation;

    }

    public function deleteVacation(DaysOff $vacation)
    {
        return $vacation->delete();
    }

    public function requestVacation($data)
    {
        $vacation = new DaysOff($data);
        $vacation->save();
        return $vacation;
    }

}
