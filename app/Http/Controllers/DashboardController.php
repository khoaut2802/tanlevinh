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
        return view('dashboard');
    }

    public function products(Request $request)
    {
        $page = $request->get('page', 1);
        $per_page = $request->get('per_page', 5);
        $group = $request->get('group', '');
        $search = $request->get('search', '');
        
        $products = Products::where('group_id', 'LIKE', "%{$group}%")->where('name', 'LIKE', "%{$search}%")->with('product_group')->paginate($per_page, $columns = ['*'], $pageName = 'page', $page)->toArray();
        
        $groups = ProductGroups::with('products')->get();
        $attrs = Attributes::get();
        // dd($products);
        return view('products', compact('products', 'groups', 'attrs'));
    }

    public function groups(Request $request)
    {
        $page = $request->get('page', 1);
        $per_page = $request->get('per_page', 5);
        $search = $request->get('search', '');
        
        $groups = ProductGroups::where('name', 'LIKE', "%{$search}%")->with('products')->paginate($per_page, $columns = ['*'], $pageName = 'page', $page)->toArray();
        // dd($products);
        return view('groups', compact('groups'));        
    }
}
