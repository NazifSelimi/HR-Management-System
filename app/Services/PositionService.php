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
        $position = new Position($data);
        $position->save();
        if($position->id)
        {
            return true;
        }
        else{
            throw new \Exception("Position not created");
        }

    }

    public function update($data, $position)
    {

        if($position->id)
        {
            $position->update($data);
            return true;
        }
        else{
            throw new \Exception("Position not updated or does not exist");
        }
    }

    public function delete($position)
    {
        $position->delete();
    }
}
