<?php

namespace App\Services;

use App\Models\DaysOff;
use Carbon\Carbon;


class DaysOffService
{
    public function store($data)
    {
        $daysOff = new DaysOff($data);
        $daysOff->save();
    }

    public function update($daysOff, $status)
    {
        if ($status) {
            $daysOff->status = $status;
            $startDate = new Carbon($daysOff->startDate);
            $endDate = new Carbon($daysOff->endDate);
            $daysTaken = $startDate->diffInDays($endDate) + 1;

            $daysOff->user->days_off -= intval($daysTaken);


            $daysOff->save();
            return response(['message' => 'Vacation has been approved'], 201);
        } else {
            return response(['message' => 'Vacation has been rejected'], 201);
        }
    }

}
