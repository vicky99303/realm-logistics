<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MarketPlaceController extends Controller
{
    public function index()
    {
        $data = array(
            'title' => 'MarketPlace'
        );
        return view('userpanel.market.marketplace', $data);
    }

    public function add_marketplace(Request $request)
    {
    }

    public function list_marketplace()
    {
        $data = array(
            'title' => 'Marketplace List'
        );
        return view('userpanel.market.list_marketplace', $data);
    }
}
