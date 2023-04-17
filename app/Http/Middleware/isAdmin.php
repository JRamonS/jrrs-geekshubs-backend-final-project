<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class isAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        try{
            if (auth()->user()->role_id == 2)

            {
                return $next($request);
            }

            Log::info('Middleware isAdmin not permissions');
            return response()->json([
                'succes' => false,
                'message' => 'You dont have permissions',
            ]);
        } catch (\Throwable $th){
            return response()->json([
                'success' => false,
                'message' => $th->getMessage(),
            ],500);
            }
    }
}
