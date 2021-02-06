<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Menus;
use App\Models\Pages;

class MenuController extends Controller
{
    public function index(Request $request)
    {
        try {
            $menus = Menus::where('parent_id', 0)->orderBy('order', 'ASC')->get();
            $pages = Pages::get();
            $data = [];

            foreach($menus as $parent) {
                $data[] = [
                    'id' => $parent->id,
                    'name' => $parent->name,
                    'slug' => $parent->slug,
                    'type' => $parent->type,
                    'childrens' => Menus::where('parent_id', '!=', 0)->where('group_id', $parent->group_id)->get()->toArray()
                ];
            }

            return view('backend.menus', compact('data', 'pages'));
        } catch(\Exception $e) {
            return $e->getMessage();
        }
    }

    public function store(Request $request)
    {
        try {
            $name = $request->name;
            $type = $request->type;
            $page = $request->page;
            $link = $request->link;

            if($type == 'page') {
                Menus::insert([
                    'parent_id'     => 0,
                    'group_id'      => 0,
                    'product_id'    => 0,
                    'page_id'       => $page,
                    'name'          => $name,
                    'type'          => $type,
                    'link'          => 'none',
                    'slug'          => 'none'
                ]);
            } else {
                Menus::insert([
                    'parent_id'     => 0,
                    'group_id'      => 0,
                    'product_id'    => 0,
                    'page_id'       => 0,
                    'name'          => $name,
                    'type'          => $type,
                    'link'          => $link,
                    'slug'          => 'none'
                ]);                
            }
            
            return redirect()->back()->withSuccess('Thêm menu thành công.');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors($e->getMessage());
        }
    }    

    public function delete(Request $request, $id)
    {
        try {
            Menus::where('id', $id)->delete();

            return redirect()->back()->withSuccess('Xóa menu thành công.');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors($e->getMessage());
        }
    }
}
