<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Tokopedia\Product as ProductTokopediaModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StockController extends Controller
{
    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        $data = array(
            'title' => 'MarketPlace',
            'breadCrumb' => 'Stock',
            'slug' => 'stock'
        );
        return view('userpanel.market.marketplace', $data);
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function stockDetail()
    {
        $data = array(
            'title' => 'Stock Detail',
            'productInfo' => ProductTokopediaModel::where('user_id', Auth::user()->id)
                ->with('getStock')
                ->get(),
        );
        return view('userpanel.market.tokopedia.stock.stock', $data);
    }
}
