<?php

namespace App\Http\Controllers;

use App\Models\Coupons;
use App\Models\Package;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PackageController extends Controller
{
    public function index()
    {
        $dataPackage = Package::all();
        $data = array(
            'title' => 'Package',
            'dataCoupon' => $dataPackage
        );
        return view('adminpanel.package', $data);
    }

    public function store(Request $request)
    {
        $message = '';
        if($request->type == 'add' || $request->type == 'edit'){
            $request->validate([
                'name' => 'required',
                'marketplace' => 'required',
                'receiving_chat' => 'required',
                'uploading_products' => 'required',
                'price' => 'required',
                'limit' => 'required',
                'receiving_orde' => 'required',
            ]);
            if($request->type == 'add'){
                $package = new Package();
                $package->name = $request->name;
                $package->marketplace = $request->marketplace;
                $package->receiving_chat = $request->receiving_chat;
                $package->uploading_products = $request->uploading_products;
                $package->receiving_orde = $request->receiving_orde;
                $package->price = $request->price;
                $package->limit = $request->limit;
                $package->created_at = date('Y-m-d h:m:s');
                $package->updated_at = date('Y-m-d h:m:s');
                $package->save();
                $message = 'Successfully Added.';
            }elseif($request->type == 'edit'){
                $package = Package::find($request->id);
                $package->name = $request->name;
                $package->name = $request->name;
                $package->marketplace = $request->marketplace;
                $package->receiving_chat = $request->receiving_chat;
                $package->uploading_products = $request->uploading_products;
                $package->receiving_orde = $request->receiving_orde;
                $package->limit = $request->limit;
                $package->price = $request->price;
                $package->updated_at = date('Y-m-d h:m:s');
                $package->save();
                $message = 'Successfully Updated.';
            }
        }elseif($request->type == 'delete'){
            $package = Package::find($request->id);
            $package->delete();
            $message = 'Successfully Deleted.';
        }
        return redirect()->back()->with('message', $message);
    }
}
