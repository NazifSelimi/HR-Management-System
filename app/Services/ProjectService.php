<?php

namespace App\Services;

use App\Http\Requests\ProjectRequest;
use App\Models\Project;
use Illuminate\Support\Facades\DB;
use function PHPUnit\Framework\throwException;
use Illuminate\Http\Request;

class ProjectService
{

    public function getProjects()
    {
        //Get all projects; Eager load department relationship
        return Project::with('departments')->get();
    }

    public function getEmployeeProjects($userId)
    {
        return Project::whereRelation('users', 'user_id', $userId)->get();
    }

    public function getEmployeeProjectById($projectId)
    {
        return Project::with('users')->findOrFail($projectId);
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

    public function assignUsers($project, Request $request)
    {
        $syncData = [];
        $response = [];

        // Get existing assignments for the project (pluck user_id and their role)
        $existingAssignments = $project->users()->pluck('projects_users.role', 'user_id')->toArray();


        // Loop through the users from the request
        foreach ($request->users as $user) {
            // If the user is not already assigned to the project
            if (!array_key_exists($user['id'], $existingAssignments)) {
                // Prepare the data for syncing (user ID and role)
                $syncData[$user['id']] = ['role' => $user['role']];
                $response[] = response()->json(['message' => 'User Assigned to Project Successfully']);
            } else {
                $response[] = response()->json(['message' => 'User already assigned to this project']);
            }
        }

        // Sync the prepared users with roles to the project
        $project->users()->syncWithoutDetaching($syncData);

        // Return the response
        return $response;
    }


    public function assignDepartments($project, $request)
    {
        $syncData = [];
        $response = [];

        // Get existing assignments for the project (pluck user_id and their role)
        $existingAssignments = $project->departments()->pluck('department_id')->toArray();


        // Loop through the users from the request
        foreach ($request->departments as $department) {
            // If the user is not already assigned to the project
            if (!array_key_exists($department['id'], $existingAssignments)) {
                // Prepare the data for syncing (user ID and role)
                $syncData[$department['id']] = ['department_id' => $department['id']];
                $response[] = response()->json(['message' => 'Department assigned to Project Successfully']);
            } else {
                $response[] = response()->json(['message' => 'Department already assigned to this project']);
            }
        }

        // Sync the prepared users with roles to the project
        $project->departments()->syncWithoutDetaching($syncData);

        // Return the response
        return $response;
    }

    public function updateUserRole($project, $users)
    {
        $updateData = [];
        $response = [];

        // Get the list of user_ids already assigned to the department
        $existingAssignments = $project->users()->pluck('user_id')->toArray();

        // Create an associative array where key is user id and value is the updated position for that user in the department
        foreach ($users as $user) {
            if (in_array($user['id'], $existingAssignments)) {
                // If user exists in the department, update their position
                $updateData[$user['id']] = ['role' => $user['role']];
                $response[] = ['message' => "User ID {$user['id']}: role updated successfully in department with ID {$project->id}."];
            } else {
                $response[] = ['message' => "User ID {$user['id']}: is not assigned to department with ID {$project->id}."];
            }
        }

        // Syncs the users' positions, updating the pivot table for the corresponding department
        $project->users()->syncWithoutDetaching($updateData);

        return $response;
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
