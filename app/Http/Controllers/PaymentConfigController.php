<?php

namespace App\Http\Controllers;

use App\Models\Package;
use App\Models\PaymentConfig;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Collection;
use Xendit\Xendit;

class PaymentConfigController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     * @throws \Xendit\Exceptions\ApiException
     */
    public function index()
    {
        $dataPackage = PaymentConfig::all();
        $data = array(
            'title' => 'Payment',
            'dataCoupon' => $dataPackage
        );
        return view('adminpanel.payment', $data);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        if($request->type == 'add' || $request->type == 'edit'){
            $request->validate([
                'token' => 'required',
            ]);
            if($request->type == 'add'){
                $payment = new PaymentConfig();
                $payment->token = $request->token;
                $payment->created_at = date('Y-m-d h:m:s');
                $payment->updated_at = date('Y-m-d h:m:s');
                $payment->save();
            }elseif($request->type == 'edit'){
                $payment = PaymentConfig::find($request->id);
                $payment->token = $request->token;
                $payment->updated_at = date('Y-m-d h:m:s');
                $payment->save();
            }
        }elseif($request->type == 'delete'){
            $payment = PaymentConfig::find($request->id);
            $payment->delete();
        }

        return redirect()->back()->with('message', 'IT WORKS!');
    }
}
