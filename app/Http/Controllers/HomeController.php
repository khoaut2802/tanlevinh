<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pages;
use App\Models\Menus;
use App\Models\HomeLayouts;
use App\Models\ProductGroups;
use App\Models\Products;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $groups = ProductGroups::orderBy('order', 'ASC')->get();

        return view('home', compact('groups'));
    }

    public function group(Request $request, $slug)
    {
        $group = ProductGroups::where('slug', $slug)->with('products')->orderBy('order', 'ASC')->first();

        return view('group', compact('group'));
    } 
    
    public function product(Request $request, $slug)
    {
        $product = Products::where('slug', $slug)->with('product_group', 'attributes', 'images')->first();

        return view('product', compact('product'));
    }  
    
    public function page(Request $request, $slug)
    {
        $page = Pages::where('slug', $slug)->first();

        return view('page', compact('page'));
    }
}
