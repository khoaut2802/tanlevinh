<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProductGroups;
use Carbon\Carbon;

class GroupController extends Controller
{
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
