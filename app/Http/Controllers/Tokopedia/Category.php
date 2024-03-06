<?php

namespace App\Http\Controllers\Tokopedia;

use App\Http\Controllers\Controller;
use App\Models\Tokopedia\StoreManagemnt;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use App\Models\Tokopedia\Category as CategoryModel;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class Category extends Controller
{
    /**
     * @param $tokenId
     * @param $fs_id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index($tokenId, $fs_id)
    {
        $categoryDetail = CategoryModel::where('fs_id',$fs_id)->get()->map(function ($values) {
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
        $data = array(
            'title' => 'Marketplace Tokopedia List',
            'categoryDetail' => $categoryDetail,
            'tokenId' => $tokenId,
            'fs_id' => $fs_id
        );
        return view('userpanel.market.tokopedia.categories', $data);
    }

    /**
     * @param $tokenId
     * @param $fs_id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function refresh($tokenId, $fs_id)
    {
        $user = Auth::user()->id;
        $response = Artisan::call('getAllCategory:tokopedia ' . $user . ' ' . $tokenId);
        if ($response == 0) {
            Session::flash('message', 'Something Went Wrong.');
            Session::flash('alert-class', 'alert-danger');
        } elseif ($response == 401) {
            Artisan::call('tokopedia:authorization ' . $user . ' ' . $tokenId);
            $response1 = Artisan::call('getAllCategory:tokopedia ' . $user . ' ' . $tokenId);
            if ($response1 == 1) {
                Session::flash('message', 'Successfully Update Category information');
                Session::flash('alert-class', 'alert-success');
            }
        } elseif ($response == 1) {
            Session::flash('message', 'Successfully Update Category information');
            Session::flash('alert-class', 'alert-success');
        }
        return redirect()->route('tokopedia-categories', ['tokenId' => $tokenId, 'fs_id' => $fs_id]);
    }
}
