<?php

namespace App\Services;

use App\Models\DaysOff;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Support\Facades\DB;


class DaysOffService
{

    public function get()
    {
        return DaysOff::with('user')->get();
    }

    public function getEmployeeDaysOff($userId)
    {
        return DaysOff::with('user')->where('user_id', $userId)->get();
    }

    public function store($data, $user)
    {
        $daysOff = new DaysOff($data);
        $daysOff->user()->associate($user->id);
        $startDate = Carbon::parse($data['start_date']);
        $endDate = Carbon::parse($data['end_date']);
        $interval = $endDate->diffInDays($startDate);


        //Check if inputted start date and end date are valid
        if ($data['start_date'] > now() && $data['end_date'] > $data['start_date'] && $interval < $user->days_off) {
            $daysOff->save();
            return response(['message' => 'Vacation has been requested'], 201);
        } else {
            return response(['message' => 'You do not have available days off or invalid dates have been selected'], 500);
        }
    }

    public function update($daysOff, $status)
    {
        //If $status exists and status of specific request is different from the input of the admin (accepted or not)
        if ($status && $daysOff->status !== $status && $status === "accept") {
            DB::beginTransaction();

            $daysOff->status = $status;           //update status of the days off request

            //Create Carbon instances of the start-end dates to manipulate the data with some functions
            $startDate = Carbon::parse($daysOff->start_date);
            $endDate = Carbon::parse($daysOff->end_date);
            $weekDays = CarbonPeriod::create($startDate, $endDate);

            $daysTaken = 0;

            //Check whether there are any weekend days in requested days off period, so they are not calculated in the employees available days off
            foreach ($weekDays as $weekDay) {
                if (!$weekDay->isWeekend()) {
                    $daysTaken++;
                }
            }

            //Subtract from available days off
            $daysOff->user->days_off -= $daysTaken;


            //Save changes in the database
            $daysOff->save();
            $daysOff->user->save();

            //Commit transaction
            DB::commit();
            return response(['message' => 'Vacation has been approved'], 201);
        } else {
            $daysOff->status = $status;
            $daysOff->save();
            return response(['message' => 'Vacation has been rejected'], 201);
        }
    }

}
