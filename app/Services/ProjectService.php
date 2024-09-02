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
        //Get all projects; Eager load department relationship
        return Project::with('departments')->get();
    }

    public function getProjectById(string $id)
    {
        //Get specific Project with its related departments and users; Also loads the related departments of the users related to the project
        return Project::with(['departments', 'users.departments'])->find($id);
    }

    public function create(array $data)
    {
        //Create new project instance and save it in the db
        $project = new Project($data);

        $project->save();

        // Attach departments to the project
        $project->departments()->attach($data['department_ids']);

        return $project;
    }

    public function update($data, $project)
    {
        // Update project fields
        $project->update($data);

        // Update the departments if they are provided
        if (isset($data['department_ids'])) {
            $project->departments()->sync($data['department_ids']); // Sync the department relationships
        }

        // Reload the project with its relationships for returning
        return $project->load('departments'); // Ensure you use 'departments' to match the relationship name
    }

    public function delete($project)
    {
        $project->delete();
    }


}
