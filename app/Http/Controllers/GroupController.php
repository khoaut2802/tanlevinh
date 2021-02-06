<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Products;
use App\Models\ProductAttrs;
use App\Models\ProductGroups;
use App\Models\Menus;
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

            if($request->group_id != null || !empty($request->group_id)) {
                ProductGroups::where('id', $request->group_id)->update([
                    'name' => $request->name,
                    'description' => $request->description           
                ]);
            } else {
                
                if(ProductGroups::where('name', $request->name)->exists()) {
                    redirect()->back()->withErrors('Nhóm sản phẩm đã tồn tại.');
                }

                $data = [
                    'name' => $request->name,
                    'description' => $request->description,
                    'created_at'    => Carbon::now()
                ];
            
                $group = ProductGroups::insertGetId($data);

                Menus::insert([
                    'parent_id'  => 0,
                    'group_id'   => $group,
                    'product_id' => 0,
                    'name'       => $request->name,
                    'slug'       => slugtify($request->name)
                ]);
            }       

            return redirect()->back()->withSuccess('Lưu thay đổi thành công');
        } catch(\Exception $e) {
            return redirect()->back()->withErrors($e->getMessage());
        }
    }

    public function detail(Request $request, $id)
    {
        try {
            return response()->json(ProductGroups::where('id', $id)->first()->toArray());
        }catch(\Exception $e) {
            return response()->json($e->gerMessage());
        }
    }

    public function delete(Request $request, $id)
    {
        try {
            $product = Products::select('id')->where('group_id', $id)->get();
            ProductAttrs::whereIn('product_id', $product)->delete();

            Products::where('group_id', $id)->delete();
            ProductGroups::where('id', $id)->delete();
            Menus::where('group_id', $id)->delete();

            return response()->json('Xóa nhóm sản phẩm thành công');
        }catch(\Exception $e) {
            return response()->json($e->getMessage());
        }
    }    
}