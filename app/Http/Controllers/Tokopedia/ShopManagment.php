<?php

namespace App\Http\Controllers\Tokopedia;

use App\Http\Controllers\Controller;
use App\Models\Tokopedia\Etalase;
use App\Models\Tokopedia\StoreManagemnt;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Models\Tokopedia\Category as CategoryModel;

class ShopManagment extends Controller
{
    /**
     * This function is used to render stores information
     * @param $tokenId
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index($tokenId)
    {
        $storeDetail = StoreManagemnt::where('token_id', $tokenId)->get();
        $data = array(
            'title' => 'Marketplace Tokopedia List',
            'storeDetail' => $storeDetail,
            'tokenId' => $tokenId
        );
        return view('userpanel.market.tokopedia.store', $data);
    }

    /**
     * This function is used to update token value and also update store data via api
     * @param $tokenId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function refresh($tokenId)
    {
        $user = Auth::user()->id;
        $response = Artisan::call('getallshopinfo:tokopedia ' . $user . ' ' . $tokenId);
        if ($response == 0) {
            Session::flash('message', 'Something Went Wrong.');
            Session::flash('alert-class', 'alert-danger');
        } elseif ($response == 401) {
            Artisan::call('tokopedia:authorization ' . $user . ' ' . $tokenId);
            $response1 = Artisan::call('getallshopinfo:tokopedia ' . $user . ' ' . $tokenId);
            if ($response1 == 1) {
                Session::flash('message', 'Successfully Update Stores information');
                Session::flash('alert-class', 'alert-success');
            }
        } elseif ($response == 1) {
            Session::flash('message', 'Successfully Update Stores information');
            Session::flash('alert-class', 'alert-success');
        }
        return redirect()->route('tokopedia-shop', $tokenId);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getShopInfo(Request $request)
    {
        $data = array();
        $fs_id = $request->input('fs_id');
        $data['storeDetail'] = StoreManagemnt::where('fs_id', $fs_id)->select('shop_id', 'shop_name')->get();
        $data['categoryDetail'] = CategoryModel::where('fs_id',$fs_id)->get()->map(function ($values) {
            $arrayValue = array();
            if($values->child_id != 0){
                $arrayValue['id'] = $values->child_id;
                $arrayValue['name'] = $values->child_name;
            }if($values->sub_child_id != 0){
                $arrayValue['id'] = $values->sub_child_id;
                $arrayValue['name'] = $values->sub_child_name;
            }
            return $arrayValue;
        })->unique('name');
        $data['etalaseDetail'] = Etalase::where('fs_id', $fs_id)->select('etalase_id', 'etalase_name')->get();
        return response()->json(array('data' => $data), 200);
    }
}
