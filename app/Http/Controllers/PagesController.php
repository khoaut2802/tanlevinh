<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pages;

class PagesController extends Controller
{
    public function index(Request $request)
    {
        $pages = Pages::get();

        return view('backend.pages', compact('pages'));
    }

    public function store(Request $request, $id = null)
    {
        $page = [];
        if($request->page_id != null) {
            $page = Pages::where('id', $request->page_id)->first();
            $page->title = $request->title;
            $page->content = $request->content;
            $page->slug = slugtify($page->title);
            $page->save();
        } else {
            $page = new Pages;
            $page->title = $request->title;
            $page->menu_id = 0;
            $page->content = $request->content;
            $page->slug = slugtify($page->title);
            $page->save();
        }

        return redirect()->route('pages')->withSuccess('Cập nhật trang thành công.');
    }

    public function detail(Request $request, $id = null)
    {
        $page = [];
        if($id) {
            $page = Pages::where('id', $id)->first();
        }

        return view('backend.page_edit', compact('page'));
    }

    public function delete(Request $request, $id)
    {
        Pages::where('id', $id)->delete();

        return redirect()->route('pages')->withSuccess('Xóa trang thành công.');
    }
}
