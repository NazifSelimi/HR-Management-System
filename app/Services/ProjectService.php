<?php

namespace App\Services;

use App\Http\Requests\ProjectRequest;
use App\Models\Project;
use Illuminate\Support\Facades\DB;
use function PHPUnit\Framework\throwException;

class ProjectService
{

    public function getProjects(): array
    {
        return Project::with('departments')->get();
    }

    public function create(array $data): Project
    {
//        $project = new Project([
//            'name' => $data['name'],
//            'description' => $data['description'],
//        ]);
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

    public function delete($project): void
    {
        try {
            $project->delete();
        } catch (\Exception $e) {
            // Handle or log the exception
            \Log::error('Error in ProjectService delete method: ' . $e->getMessage());
            throw $e; // Re-throw the exception to be caught in the controller
        }
    }



}
