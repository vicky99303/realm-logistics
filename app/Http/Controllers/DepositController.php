<?php

namespace App\Http\Controllers;

use App\Models\Deposit;
use App\Models\Package;
use Illuminate\Http\Request;

class DepositController extends Controller
{
    public function index()
    {
        $data = array(
            'title' => 'Deposit',
            'dataArray' => Deposit::all()
        );
        return view('adminpanel.deposit', $data);
    }

    public function store(Request $request)
    {
        $message = '';
        if ($request->type == 'add' || $request->type == 'edit') {
            $request->validate([
                'name' => 'required',
                'price' => 'required',
            ]);
            if ($request->type == 'add') {
                $deposit = new Deposit();
                $deposit->name = $request->name;
                $deposit->price = $request->price;
                $deposit->created_at = date('Y-m-d h:m:s');
                $deposit->updated_at = date('Y-m-d h:m:s');
                $deposit->save();
                $message = 'Successfully Added.';
            } elseif ($request->type == 'edit') {
                $deposit = Deposit::find($request->id);
                $deposit->name = $request->name;
                $deposit->price = $request->price;
                $deposit->updated_at = date('Y-m-d h:m:s');
                $deposit->save();
                $message = 'Successfully Updated.';
            }
        } elseif ($request->type == 'delete') {
            $deposit = Deposit::find($request->id);
            $deposit->delete();
            $message = 'Successfully Deleted.';
        }
        return redirect()->back()->with('message', $message);
    }
}
