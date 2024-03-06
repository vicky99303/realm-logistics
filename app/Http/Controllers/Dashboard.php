<?php

namespace App\Http\Controllers;

use App\Models\Deposit;
use App\Models\Package;
use App\Models\User;
use Illuminate\Http\Request;

class Dashboard extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        $data = array(
            'title' => 'Dashboard',
        );
        return view('adminpanel.dashboard', $data);
    }
}
