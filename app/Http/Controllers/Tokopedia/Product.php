<?php

namespace App\Http\Controllers\Tokopedia;

use App\Http\Controllers\Controller;
use App\Models\Tokopedia\TokopediaToken;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use App\Models\Tokopedia\Product as ProductTokopediaModel;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class Product extends Controller
{

    /**
     * This function is used to render all product of specific shop
     *
     * @param $tokenId
     * @param $fs_id
     * @param $shop_id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function productInfo($tokenId, $fs_id, $shop_id)
    {
        $data = array(
            'title' => 'Product',
            'productInfo' => ProductTokopediaModel::where('shop_id', $shop_id)
                ->with('getImages')
                ->with('getCategories')
                ->with('getStock')
                ->get(),
            'tokenId' => $tokenId,
            'fs_id' => TokopediaToken::where('user_id', Auth::user()->id)->get(),
            'shop_id' => $shop_id,
        );
        return view('userpanel.market.tokopedia.product.product', $data);
    }

    /**
     * This function is used to update token value and also update store data via api
     * @param $tokenId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function refresh($tokenId, $fs_id, $shop_id)
    {

        $user = Auth::user()->id;
        if($tokenId != 0 && $fs_id != 0 && $shop_id != 0){
            $response = Artisan::call('getAllProduct:tokopedia ' . $user . ' ' . $tokenId);
            if ($response == 0) {
                Session::flash('message', 'Something Went Wrong.');
                Session::flash('alert-class', 'alert-danger');
            } elseif ($response == 401) {
                Artisan::call('tokopedia:authorization ' . $user . ' ' . $tokenId);
                $response1 = Artisan::call('getAllProduct:tokopedia ' . $user . ' ' . $tokenId);
                if ($response1 == 1) {
                    Session::flash('message', 'Successfully Update Product information');
                    Session::flash('alert-class', 'alert-success');
                }
            } elseif ($response == 1) {
                Session::flash('message', 'Successfully Update Product information');
                Session::flash('alert-class', 'alert-success');
            }
            return redirect()->route('tokopedia-product', ['tokenId' => $tokenId, 'fs_id' => $fs_id, 'shop_id' => $shop_id]);
        }else{
            $tokenDetail = TokopediaToken::where('user_id', $user)->get();
            foreach($tokenDetail as $singleDetail){
                $tokenId = $singleDetail->id;
                Artisan::call('tokopedia:authorization ' . $user . ' ' . $tokenId);
                $response = Artisan::call('getAllProduct:tokopedia ' . $user . ' ' . $tokenId);
                if ($response == 0) {
                    Session::flash('message', 'Something Went Wrong.');
                    Session::flash('alert-class', 'alert-danger');
                    return redirect()->back();
                } elseif ($response == 401) {
                    Artisan::call('tokopedia:authorization ' . $user . ' ' . $tokenId);
                    $response1 = Artisan::call('getAllProduct:tokopedia ' . $user . ' ' . $tokenId);
                    if ($response1 == 1) {
                        Session::flash('message', 'Successfully Update Product information');
                        Session::flash('alert-class', 'alert-success');
                    }
                } elseif ($response == 1) {
                    Session::flash('message', 'Successfully Update Product information');
                    Session::flash('alert-class', 'alert-success');
                }
            }
            return redirect()->back();
        }
    }
}
