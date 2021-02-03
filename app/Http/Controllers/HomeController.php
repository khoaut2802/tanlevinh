<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pages;
use App\Models\Menus;
use App\Models\HomeLayouts;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $layouts = HomeLayouts::with('menus', 'menus.page')->orderBy('order', 'ASC')->get();
        // dd($layouts);
        return view('home', compact('layouts'));
    }
    
    public function page(Request $request, $slug)
    {
        $menu = Menus::where('slug', $slug)->first();
        $page = Pages::where('menu_id', $menu->id)->first();

        return view('page', compact('page'));
    }
}
