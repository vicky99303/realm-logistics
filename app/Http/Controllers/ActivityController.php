<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ActivityController extends Controller
{
    public function index()
    {
        $data = array(
            'title' => 'Activity'
        );
        return view('adminpanel.activity', $data);
    }
}
