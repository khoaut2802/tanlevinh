<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProductGroups;
use Carbon\Carbon;

class GroupController extends Controller
{
    public function index(Request $request)
    {
        $page = $request->get('page', 1);
        $per_page = $request->get('per_page', 5);
        $search = $request->get('search', '');
        
        $groups = ProductGroups::where('name', 'LIKE', "%{$search}%")->with('products')->paginate($per_page, $columns = ['*'], $pageName = 'page', $page)->toArray();
        // dd($products);
        return view('backend.groups', compact('groups'));        
    }

    public function store(Request $request)
    {
        try {
        $data = [
            'name' => $request->name,
            'description' => $request->description,
            'created_at'    => Carbon::now()
        ];

        ProductGroups::insert($data);

        return redirect()->back()->withSuccess('Tạo nhóm sản phẩm thành công');
        } catch(\Exception $e) {
            return redirect()->back()->withError('Tạo nhóm sản phẩm thành công');
        }
    }
}
