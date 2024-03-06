<?php

namespace App\Http\Controllers;

use App\Models\Coupons;
use Illuminate\Http\Request;

class CouponsController extends Controller
{
    public function index()
    {
        $dataCoupon = Coupons::all();
        $data = array(
            'title' => 'Coupons',
            'dataCoupon' => $dataCoupon
        );
        return view('adminpanel.coupons', $data);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        if($request->type == 'add' || $request->type == 'edit'){
            $request->validate([
                'name' => 'required',
                'opening_date' => 'required',
                'closing_date' => 'required',
                'limit' => 'required',
                'discount_amount' => 'required',
            ]);
            if($request->type == 'add'){
                $coupons = new Coupons();
                $coupons->name = $request->name;
                $coupons->opening_date = $request->opening_date;
                $coupons->limit = $request->limit;
                $coupons->closing_date = $request->closing_date;
                $coupons->discount_amount = $request->discount_amount;
                $coupons->discount_amount = $request->discount_amount;
                $coupons->created_at = date('Y-m-d h:m:s');
                $coupons->updated_at = date('Y-m-d h:m:s');
                $coupons->save();
            }elseif($request->type == 'edit'){
                $coupons = Coupons::find($request->id);
                $coupons->name = $request->name;
                $coupons->opening_date = $request->opening_date;
                $coupons->limit = $request->limit;
                $coupons->closing_date = $request->closing_date;
                $coupons->discount_amount = $request->discount_amount;
                $coupons->discount_amount = $request->discount_amount;
                $coupons->updated_at = date('Y-m-d h:m:s');
                $coupons->save();
            }
        }elseif($request->type == 'delete'){
            $payment = Coupons::find($request->id);
            $payment->delete();
        }
        return redirect()->back()->with('message', 'IT WORKS!');
    }
}
