<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class dashboardController extends Controller
{
    public function index()
    {
        $title = "Dashboard ";
        $headerTitle = "Dashboard";
        return view('dashboard', compact('title', 'headerTitle'));
    }
}
