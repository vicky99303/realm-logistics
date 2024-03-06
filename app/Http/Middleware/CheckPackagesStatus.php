<?php

namespace App\Http\Middleware;

use App\Models\BuyPackageRecord;
use App\Models\PaymentRecord;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckPackagesStatus
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
//        $packageStatus = false;
//        if (Auth::user()->superadmin != 1) {
//            $dataPaymentRecord = BuyPackageRecord::where('user_id', Auth::user()->id)->get();
//            if ($dataPaymentRecord->isEmpty()) {
//                $packageStatus = true;
//            }
//        }
//        $request->merge(array("packageStatus" => $packageStatus));
        return $next($request);
    }
}
