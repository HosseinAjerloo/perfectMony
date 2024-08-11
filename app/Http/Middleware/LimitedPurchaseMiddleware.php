<?php

namespace App\Http\Middleware;

use App\Filters\PurchaseConditions;
use App\Http\Traits\HasConfig;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class LimitedPurchaseMiddleware
{
    use HasConfig;

    /**
     * Handle an incoming request.
     *
     * @param \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response) $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $filters=new PurchaseConditions();
        $statusPurchase = $filters->filters();

        if (is_bool($statusPurchase)) {
            return $next($request);
        }
        return redirect()->back()->withErrors(['error' => $statusPurchase]);

    }
}
