<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SalesReportController extends Controller
{
    public function index()
    {
        $data = array(
            'title' => 'MarketPlace',
            'breadCrumb' => 'Sale Reports',
            'slug' => 'sale-reports'
        );
        return view('userpanel.market.marketplace', $data);
    }

    public function detail()
    {
        $data = array(
            'title' => 'Sale Reports'
        );
        return view('userpanel.sale_report', $data);
    }
}
