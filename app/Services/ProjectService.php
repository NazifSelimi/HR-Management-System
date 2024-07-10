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
        $project = new Project($data);
        $project->save();
        return $project;
    }

    public function update($data, $project)
    {
        $project->update($data);
        return $project;
    }

    public function delete($project)
    {
        $project->delete();
    }



}
