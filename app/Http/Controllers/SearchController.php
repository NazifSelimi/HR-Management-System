<?php

namespace App\Http\Controllers;

use App\Models\DaysOff;
use App\Models\Department;
use App\Models\Project;
use App\Models\User;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        $request->validate([
            'searchType' => 'required|string',
            'query' => 'required|string',
        ]);

        $searchTerm = $request->input('query');
        $searchType = $request->input('searchType');

        switch ($searchType) {
            case 'Projects':
                $projects = Project::with('departments') // Eager load the 'departments' relationship
                ->where('name', 'ILIKE', "%{$searchTerm}%") // Case-insensitive search using ILIKE
                ->get();

                return response()->json([
                    'projects' => $projects
                ]);

            case 'Employees':
                $users = User::where('first_name', 'ILIKE', "%{$searchTerm}%")
                    ->orWhere('email', 'ILIKE', "%{$searchTerm}%")
                    ->orWhere('id', 'LIKE', "%{$searchTerm}%") // Keeping LIKE for numeric fields if needed
                    ->get();

                return response()->json([
                    'user' => $users
                ]);

            case 'Departments':
                $departments = Department::where('name', 'ILIKE', "%{$searchTerm}%")
                    ->get();

                return response()->json([
                    'departments' => $departments
                ]);

            default:
                return response()->json([
                    'error' => 'Invalid search type'
                ], 400);
        }
    }
}
