<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckChatAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $id = $this->route('chat');
        $thread = Messages::where('product_id', $productId)
            ->where('user_id', $userId)
            ->get();

        dd($thread);

        return $next($request);
    }
}
