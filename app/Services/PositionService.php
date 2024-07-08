<?php

namespace App\Services;

use App\Models\Position;
use Illuminate\Support\Facades\DB;

class PositionService
{
    public function getPositions()
    {
        return Position::all();
    }

    public function create($data)
    {
        DB::beginTransaction();
        $position = new Position($data);
        $position->save();
        if($position->id)
        {
            DB::commit();
            return true;
        }
        else{
            DB::rollBack();
            throw new \Exception("Position not created");
        }

    }

    public function update($data, $position)
    {
        DB::beginTransaction();

        if($position->id)
        {
            $position->update($data);
            $position->save();
            DB::commit();
            return true;
        }
        else{
            DB::rollBack();
            throw new \Exception("Position not updated or does not exist");
        }
    }

    public function delete($position)
    {
        $position->delete();
    }
}
