<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Banners;
use Carbon\Carbon;

class BannerController extends Controller
{
    public function index(Request $request)
    {
        try {
            $banners = Banners::get();
            return view('backend.banners', compact('banners'));
        } catch(\Exception $e) {
            return redirect()->back()->withErrors($e->getMessage());
        }
    }

    public function store(Request $request)
    {
        try {

            if ($request->hasFile('image')) {
                if ($request->file('image')->isValid()) {
                    $validated = $request->validate([
                        'image' => 'mimes:jpeg,png,gif|max:2048',
                    ]);                    
                    
                    $file_name = 'banner_'.time();
                    $extension = $request->image->extension();
                    $request->file('image')->storeAs('uploads',$file_name.".".$extension, 'public');

                    $file = 'storage/uploads/'.$file_name.".".$extension;

                    Banners::insert([
                        'name'       => $request->name ?? '',
                        'link'       => $request->link,
                        'position'   => $request->position,
                        'image'      => $file,
                        'created_at' => Carbon::now()
                    ]);                    
                } else {
                    return response()->json('Tệp ảnh không hợp lệ (định dạng cho phép: jpg,png,gif)', 400);
                }
            } else {
                return response()->json('Vui lòng chọn đường dẫn tới tệp ảnh', 400);
            }

            return response()->json('Thêm banner thành công.');
        } catch(\Exception $e) {
            return response()->json($e->getMessage(), 400);
        }
    }

    public function delete(Request $request, $id)
    {
        try {
            Banners::where('id', $id)->delete();

            return redirect()->back()->withSuccess('Xóa banner thành công.');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors($e->getMessage());
        }
    }
}
