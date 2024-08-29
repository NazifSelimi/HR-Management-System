<?php

namespace App\Services;

use App\Models\DaysOff;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Support\Facades\DB;


class DaysOffService
{
    public function store($data)
    {
        $daysOff = new DaysOff($data);
        if ($data['start_date'] > now() && $data['end_date'] > $data['start_date']) {
            $daysOff->save();
            return response(['message' => 'Vacation has been requested'], 201);
        } else {
            return response(['message' => 'You do not have available days off or invalid dates have been selected'], 500);
        }
    }

    public function update($daysOff, $status)
    {
        if ($status && $daysOff->status !== $status) {
            DB::beginTransaction();

            $daysOff->status = $status;

            $startDate = Carbon::parse($daysOff->start_date);
            $endDate = Carbon::parse($daysOff->end_date);
            $weekDays = CarbonPeriod::create($startDate, $endDate);

            $daysTaken = 0;
            foreach ($weekDays as $weekDay) {
                if (!$weekDay->isWeekend()) {
                    $daysTaken++;
                }
            }
            $daysOff->user->days_off -= $daysTaken;

            $daysOff->save();
            $daysOff->user->save();

            DB::commit();
            return response(['message' => 'Vacation has been approved'], 201);
        } else {
            return response(['message' => 'Vacation has been rejected'], 201);
        }
    }

}
