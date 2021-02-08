<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Attributes;
use Carbon\Carbon;

class AttributesController extends Controller
{
    public function index(Request $request)
    {
        $attrs = Attributes::get();

        if($request->has('attr')) {
            $selected_attr = Attributes::where('id', $request->get('attr'))->first();
        } else {
            $selected_attr = json_decode($attrs[0]);
        }

        return view('backend.attributes', compact('attrs', 'selected_attr'));
    }

    public function delete(Request $request)
    {
        $attr = $request->get('attr');
        $value = $request->get('value', 'none');

        if($value == 'none') {
            Attributes::where('id', $attr)->delete();

            return response()->json('Xóa thuộc tính thành công', 200);
        } else {
            $attr = Attributes::where('id', $attr)->first();

            $options = json_decode($attr->options, true);
            unset($options[$value]);

            $attr->options = json_encode((object)$options);
            $attr->save();

            return response()->json('Xóa giá trị thuộc tính thành công', 200);
        }
    }

    public function store(Request $request)
    {
        try {
            $name = $request->name;
            $type = $request->type;

            $attr = Attributes::insertGetId([
                'name' => $name,
                'type' => $type,
                'options' => json_encode([]),
                'status' => 'enabled',
                'created_at' => Carbon::now()
            ]);

            return redirect()->route('attributes', ['attr' => $attr])->withSuccess('Thêm thuộc tính thành công');
        } catch(\Exception $e) {
            return redirect()->back()->withErrors($e->getMessage());
        }
    }

    public function update(Request $request)
    {
        try {
            $attr = $request->attr;
            $data = $request->all();
            $detail = Attributes::where('id', $attr)->first();
            $options = json_decode($detail->options, true);

            $ar = [];
            $ar_to_string = implode('|',$data);

            for($i = 0; $i <= count($options) - 1; $i++) {
                if(isset($data['option_'.$i.'_name'])) {
                    $ar[] = ['name' => $data['option_'.$i.'_name'], 'price' => $data['option_'.$i.'_price'] ?? 0];
                }
            }

            $addition_option = -1;

            foreach($data as $key => $value){
                if(strstr($key,'addition')){
                    $addition_option = $addition_option + 1;
                }
            }            

            for($i = 0; $i <= $addition_option; $i++) {
                if(isset($data['addition_'.$i.'_name'])) {
                    $ar[] = ['name' => $data['addition_'.$i.'_name'], 'price' => $data['addition_'.$i.'_price'] ?? 0];
                }
            }

            $attr = Attributes::where('id', $attr)->update([
                'options' => json_encode($ar)
            ]);

            return redirect()->back()->withSuccess('Cập nhật thuộc tính thành công');
        } catch(\Exception $e) {
            return redirect()->back()->withErrors($e->getMessage());
        }
    }
}
