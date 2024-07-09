<?php

namespace App\Services;


use App\Models\Vacation;

class VacationService
{
    public function getVacations()
    {
        return Vacation::all();

    }

    public function getVacation(string $id)
    {
        return Vacation::query()->where('id', $id)->first();
    }
    public function getVacationsByUser(string $userId)
    {
        return Vacation::query()->where('user_id', $userId)->get();
    }

    public function updateVacation($data, $vacation)
    {
        $vacation->update($data);
        return $vacation;

    }

    public function deleteVacation(Vacation $vacation)
    {
        return $vacation->delete();
    }

    public function requestVacation($data)
    {
        $vacation = new Vacation($data);
        $vacation->save();
        return $vacation;
    }

}
