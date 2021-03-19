<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Machines;

class MachinesController extends Controller
{
    public function index(Request $request)
    {
        $machines = Machines::get();

        return view('backend.machines', compact('machines'));
    }

    public function store(Request $request)
    {
        $machines = Machines::create($request->only(['name']));

        return redirect()->back()->withSuccess('Thêm máy sản xuất thành công');
    }

    public function delete($id)
    {
        Machines::where('id', $id)->delete();

        return redirect()->back()->withSuccess('Xóa máy sản xuất thành công');
    }
}
