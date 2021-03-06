<?php

namespace App\Http\Middleware;

use Closure;
use App\Transaction;

class IsInCart
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $transaction = Transaction::findOrFail($request->id);
        
        // if the transaction status is still IN_CART
        if($transaction->transaction_status_id == 1){
            return $next($request);
        }

        return redirect()->route('checkout.success', $transaction->id);
    }
}
