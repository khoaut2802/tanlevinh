<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Products;
use App\Models\ProductGroups;
use App\Models\Attributes;

class DashboardController extends Controller
{
    public function index()
    {
        return view('backend.dashboard');
    }
}
