<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class Admin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        try {
            // Get the authenticated user from the request
            $user = $request->user();

            // Debugging: Log the user info
            Log::info('Authenticated user in Admin middleware', ['user_id' => $user->id, 'role' => $user->role]);

            // Check if the user is authenticated
            if (!$user) {
                return response()->json(['message' => 'Unauthorized'], Response::HTTP_UNAUTHORIZED);
            }

            // Ensure that the authenticated user is an admin
            if ($user->role !== 'admin') {  // Ensure the 'role' field exists and is correctly set in your users table
                Log::info('User does not have admin role', ['user_id' => $user->id, 'role' => $user->role]);
                return response()->json(['message' => 'Forbidden - You do not have access'], Response::HTTP_FORBIDDEN);
            }

            return $next($request);  // Allow the request to proceed if the user is an admin
        } catch (\Exception $e) {
            // Log the exception for debugging
            Log::error('Error in Admin middleware', ['error' => $e->getMessage()]);
            return response()->json(['message' => 'Internal Server Error'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
