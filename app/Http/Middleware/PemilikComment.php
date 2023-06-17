<?php

namespace App\Http\Middleware;

use App\Models\comments;
use App\Models\posts;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PemilikComment
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
        $commenter = comments::findOrFail($request->id)->author;
        $user = Auth::user()->id;

        if ($commenter !== $user){
            return response()->json('kamu bukan pemilik comment ini');
        }

    


        return $next($request);
    }
}
