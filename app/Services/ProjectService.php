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
        return Project::with('departments')->get();
    }

    public function create(array $data): Project
    {
        $project = new Project([
            'name' => $data['name'],
            'description' => $data['description'],
        ]);

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
            $project->department()->sync($data['department_ids']); // Sync the department relationships
        }

        // Reload the project with its relationships for returning
        return $project->load('department');
    }

    public function delete($project)
    {
        $project->delete();
    }



}
