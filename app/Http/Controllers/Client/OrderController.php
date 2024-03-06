<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Tokopedia\Orders;
use App\Models\Tokopedia\Product;
use App\Models\Tokopedia\Product as ProductTokopediaModel;
use App\Models\Tokopedia\StoreManagemnt;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        $data = array(
            'title' => 'MarketPlace',
            'breadCrumb' => 'Order',
            'slug' => 'order'
        );
        return view('userpanel.market.marketplace', $data);
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function orderDetail()
    {
        $value = 3;
        $data = array(
            'title' => 'Order Detail',
            'orderDetail' => StoreManagemnt::where('user_id', Auth::user()->id)
                ->with(['getOrderDetail', 'productDetail' => function($q) use($value) {
                    // Query the name field in status table
                    $q->where('status', '!=', $value); // '=' is optional
                }])
                ->get(),
        );
        return view('userpanel.market.tokopedia.orders.order', $data);
    }

    public function new()
    {
        $data = array(
            'title' => 'New Order'
        );
        return view('userpanel.orders.new_order', $data);
    }
}
