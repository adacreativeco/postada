<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TeamMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->user()) {
            if (!$request->user()->current_team_id) {
                $personalTeam = $request->user()->ownedTeams()->where('personal_team', true)->first();
                if ($personalTeam) {
                    $request->user()->forceFill(['current_team_id' => $personalTeam->id])->save();
                }
            }

            // Optional: Verify user actually belongs to the current team
            // if (!$request->user()->allTeams()->contains('id', $request->user()->current_team_id)) {
            //      abort(403);
            // }
        }

        return $next($request);
    }
}
