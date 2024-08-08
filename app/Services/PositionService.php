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
        return $position;
    }

    public function update($data, $position)
    {
        $position->update($data);
        return $position;
    }

    public function delete($position)
    {
        $position->delete();
    }
}
