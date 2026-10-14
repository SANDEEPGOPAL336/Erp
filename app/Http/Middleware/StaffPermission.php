<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class StaffPermission
{
    public function handle(
        Request $request,
        Closure $next,
        string $permissionKey
    ): Response {

        $user = $request->user();

        /*
        |--------------------------------------------------------------------------
        | User must be logged in as staff
        |--------------------------------------------------------------------------
        */

        if (
            !$user ||
            $user->role !== 'staff'
        ) {
            abort(403);
        }


        /*
        |--------------------------------------------------------------------------
        | Staff profile must exist
        |--------------------------------------------------------------------------
        */

        $staffProfile =
            $user->staffProfile;


        if (
            !$staffProfile ||
            !$staffProfile->is_active
        ) {
            abort(403);
        }


        /*
        |--------------------------------------------------------------------------
        | Check permission
        |--------------------------------------------------------------------------
        */

        if (
            !$staffProfile->hasPermission(
                $permissionKey
            )
        ) {
            abort(
                403,
                'You do not have permission to access this module.'
            );
        }


        return $next($request);
    }
}