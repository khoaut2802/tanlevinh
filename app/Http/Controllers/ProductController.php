<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Products;
use App\Models\ProductGroups;
use App\Models\Attributes;
use App\Models\ProductAttrs;
use App\Models\Menus;
use Carbon\Carbon;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $page = $request->get('page', 1);
        $per_page = $request->get('per_page', 20);
        $group = $request->get('group', '');
        $search = $request->get('search', '');
        
        $products = Products::where('group_id', 'LIKE', "%{$group}%")
        ->where('name', 'LIKE', "%{$search}%")
        ->with('product_group')
        ->orderBy('id','DESC')
        ->paginate($per_page, $columns = ['*'], $pageName = 'page', $page)->toArray();
        
        $groups = ProductGroups::with('products')->get();
        $attrs = Attributes::get();
        // dd($products);
        return view('backend.products', compact('products', 'groups', 'attrs'));
    }

    public function store(Request $request)
    {
        try {
            $name = $request->name;
            $price = $request->price;
            $unit = $request->unit ?? 'cái';
            $desc = $request->description;
            $group = $request->group_id ?? 0;
            $attrs = $request->attrs;
            $image = $request->image;
            $file_name = time();
            $file = 'none';
            $slug = slugtify($name);

            if(Products::where('slug', $slug)->exists()) {
                return response()->json('Sản phẩm đã tồn tại.', 400);
            }

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

            $result = Products::insertGetId([
                'name'        => $name,
                'price'       => $price ?? 0,
                'unit'        => $unit,
                'description' => $desc,
                'group_id'    => $group,
                'attrs'       => json_encode($attrs),
                'image'       => $file,
                'slug'        => $slug,
                'created_at'  => Carbon::now()
            ]);
            
            $insertAttrs = [];
            foreach($attrs as $attr) {
                $insertAttrs[] = [
                    'product_id' => $result,
                    'attr_id'    => $attr,
                    'values'     => json_encode([])
                ];
            }

            ProductAttrs::insert($insertAttrs);

            Menus::insert([
                'parent_id' => Menus::where([['group_id', '=', $group], ['parent_id', '=', 0]])->first()->id,
                'group_id'  => $group,
                'product_id'=> $result,
                'name'      => $name,
                'order'     => 0,
                'created_at'=> Carbon::now()
            ]);

            return response()->json($result);
        } catch(\Exception $e) {
            return response()->json($e->getMessage(), 400);
        }
    }

    public function updateView(Request $request, $id)
    {
        try {
            $product = Products::where('id', $id)->with('product_group')->first();

            if(empty($product) || $product == null) {
                return redirect()->back()->withErrors('Sản phẩm không tồn tại');
            }

            $product_attrs = ProductAttrs::where('product_id', $id)->with('attr')->get();
            $product = $product->toArray();
            $groups = ProductGroups::with('products')->get();

            return view('backend.product_update', compact('product', 'product_attrs', 'groups'));
        } catch(\Exception $e) {
            return redirect()->back()->withErrors($e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $product = Products::where('id', $id)->with('product_group')->first();

            if(empty($product) || $product == null) {
                return redirect()->back()->withErrors('Sản phẩm không tồn tại');
            }

            $attributes = Attributes::get();
            $attr_value = [];

            foreach($attributes as $attr) {
                if($request->has('attr_'.$attr->id)) {
                    ProductAttrs::where('attr_id', $attr->id)->update([
                        'values' => json_encode($request->get('attr_'.$attr->id))
                    ]);
                }
            }

            if($product->name != $request->name && Products::where('slug', slugtify($request->name))->exists()) {
                return response()->json('Sản phẩm đã tồn tại.', 400);
            }

            $check_qty = explode(',',$request->min_qty);
            if(count($check_qty) <= 0 || !is_numeric(str_replace(',', '',$request->min_qty))) {
                return response()->json('Số lượng bạn nhập không hợp lệ', 400);
            }

            $product->name = $request->name;
            $product->min_qty = $request->min_qty ?? 0;
            $product->price = $request->price ?? 0;
            $product->unit = $request->unit ?? 'cái';
            $product->slug = slugtify($request->name);
            $product->description = $request->description;
            $product->group_id = $request->group_id;

            if($request->has('image')) {
                if($request->image->isValid()) {
                    $file_name = time();
                    $extension = $request->image->extension();
                    $request->file('image')->storeAs('uploads',$file_name.".".$extension, 'public');

                    $product->image = 'storage/uploads/'.$file_name.".".$extension;                    
                }
            }

            $product->save();

            return response()->json('Cập nhật sản phẩm thành công.');
        } catch(\Exception $e) {
            return response()->json($e->getMessage(), 400);
        }        
    }

    public function delete(Request $request, $id)
    {
        try {
            $product = Products::where('id', $id)->delete();
            $product_attrs = ProductAttrs::where('product_id', $id)->delete();
            $menu = Menus::where('product_id', $id)->delete();
            
            return response()->json('Xóa sản phẩm thành công.');
        } catch(\Exception $e) {
            return response()->json($e->gerMessage(), 400);
        }        
    }

}
