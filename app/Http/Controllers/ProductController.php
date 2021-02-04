<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Products;
use Carbon\Carbon;

class ProductController extends Controller
{
    public function store(Request $request)
    {
        try {
            $name = $request->name;
            $desc = $request->description;
            $group = $request->group_id;
            $attrs = $request->attrs;
            $image = $request->image;
            $file_name = time();
            $file = 'none';

            if ($request->hasFile('image')) {
                if ($request->file('image')->isValid()) {
                    $validated = $request->validate([
                        'image' => 'mimes:jpeg,png,gif|max:2048',
                    ]);                    

                    $extension = $request->image->extension();
                    $request->file('image')->storeAs('uploads',$file_name.".".$extension, 'public');

                    $file = 'storage/uploads/'.$file_name.".".$extension;
                }
            }

            $result = Products::insert([
                'name' => $name,
                'description' => $desc,
                'group_id'    => $group,
                'attrs'       => json_encode($attrs),
                'image'       => $file,
                'created_at'  => Carbon::now()
            ]);

            return response()->json(['status' => 'success', 'message' => 'Tạo sản phẩm thành công.']);
        } catch(\Exception $e) {
            return response()->json(['status' => 'success', 'message' => $e->getMessage()]);
        }
    }
}
