<?php

namespace App\Services;

use App\Http\Requests\ProjectRequest;
use App\Models\Project;
use Illuminate\Support\Facades\DB;
use function PHPUnit\Framework\throwException;

class ProjectService
{

    public function getProjects()
    {
        return Project::all();
    }

    public function create($data)
    {
        DB::beginTransaction();
            $project = new Project($data);
            $project->save();
            if($project->id)
            {
                DB::commit();
                return true;
            }
            else{
                DB::rollBack();
                throw new \Exception("Project not created");
            }

    }

    public function update($data, Project $project)
    {
        DB::beginTransaction();

        if($project->id)
        {
            $project->update($data);
            $project->save();
            DB::commit();
            return true;
        }
        else{
            DB::rollBack();
            throw new \Exception("Project not updated or does not exist");
        }
    }

    public function delete(Project $project)
    {
        $project->delete();
    }



}
