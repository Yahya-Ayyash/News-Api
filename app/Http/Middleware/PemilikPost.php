<?php

namespace App\Http\Middleware;

use App\Models\posts;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PemilikPost
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {

        $writer = posts::findOrFail($request->id);
        $user = Auth::user();

        if ($writer->author !== $user->id){
            return response()->json('kamu bukan pemilik post ini');
        }

        return $next($request);
    }
}
