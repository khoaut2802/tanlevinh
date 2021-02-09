<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pages;
use App\Models\Menus;
use App\Models\HomeLayouts;
use App\Models\ProductGroups;
use App\Models\Products;
use Session;

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

        if(empty($group))
            return abort(404);

        return view('group', compact('group'));
    } 
    
    public function product(Request $request, $slug)
    {
        $product = Products::where('slug', $slug)->with('product_group', 'attributes', 'images')->first();

        if(empty($product))
            return abort(404);
            
        return view('product', compact('product'));
    }  
    
    public function page(Request $request, $slug)
    {
        $page = Pages::where('slug', $slug)->first();

        if(empty($page))
            return abort(404);

        return view('page', compact('page'));
    }

    public function cart(Request $request)
    {
        return view('cart');
    }

    public function cartAdd(Request $request)
    {
        $data = $request->all();
        $cart = $request->session()->get('cart', 'empty');

        $product = Products::where('id', $data['product_id'] ?? null)->first();

        if(!empty($product) || $product != null) {

            $sum_total = $product->price;
            $attrs = getCartAttrs($data);

            // dd($attrs);
            foreach($attrs as $attr) {
                if(is_numeric($attr['values']['price']))
                    $sum_total = $sum_total + $attr['values']['price'];
            }

            $item = [
                'product_id'    => $product->id,
                'product_name'  => $product->name,
                'product_price' => $product->price,
                'image'         => $product->image,
                'total_amount'  => $sum_total,
                'quantity'      => $data['qty'] ?? 1,
                'attrs'         => $attrs
            ];
            
            if($cart == 'empty' || $cart == null) {
                $request->session()->put('cart', [$item]);
            } else {
                $request->session()->push('cart', $item);
            }
        }

        return redirect()->route('cart');
    }

    public function cartDelete(Request $request)
    {
        if($request->has('item')) {
            $cart = $request->session()->get('cart');
            unset($cart[$request->get('item')]);

            $newcart = $cart;
            $request->session()->put('cart', $newcart);

            // $request->session()->put($newcart);

            return redirect()->back()->withSuccess('Đã xóa sản phẩm khỏi giỏ hàng.');
        } else {
            return redirect()->route('home');
        }
    }
}
