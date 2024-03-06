<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\PaymentRecord;
use App\Models\Tokopedia\Product as ProductTokopediaModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Dashboard extends Controller
{
    public function index()
    {
        $dataPaymentRecord = PaymentRecord::where('user_id', Auth::user()->id)->get();
        if ($dataPaymentRecord->isEmpty()) {
            return redirect()->route('packages');
        }
        $dataPaymentRecord = PaymentRecord::where('user_id', Auth::user()->id)->sum('capture_amount');
        $numberOfPackageBuy = PaymentRecord::where('user_id', Auth::user()->id)->count('id');
        $productCountTokopediaCount = ProductTokopediaModel::where('user_id', Auth::user()->id)->count('id');
        $data = array(
            'title' => 'Dashboard',
            'dataPaymentRecord' => $dataPaymentRecord,
            'productCountTokopediaCount' => $productCountTokopediaCount,
            'numberOfPackageBuy' => $numberOfPackageBuy
        );
        return view('userpanel.dashboard', $data);
    }
}
