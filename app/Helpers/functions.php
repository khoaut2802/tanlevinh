<?php
use App\Models\Products;
use App\Models\ProductGroups;
use App\Models\Attributes;
use App\Models\ProductAttrs;

if(!function_exists('getSetting')) {
    function getSetting($key, $default = '') {
        $settings = new \App\Models\Settings;

        return $settings->where('key', $key)->first()->value ?? $default;
    }
}

if(!function_exists('getBanner')) {
    function getBanner($position) {
        $banners = new \App\Models\Banners;
        $items = $banners->where('position', $position)->get();

        return $items ?? '';
    }
}

if(!function_exists('getMenus')) {
    function getMenus() {
        $menus = new \App\Models\Menus;
        $list = $menus->where('parent_id', 0)->orderBy('order', 'ASC')->limit(6)->get();
        $ar = [];

        foreach($list as $menu) {
            $ar[] = [
                'id'   => $menu->id,
                'name' => $menu->name,
                'type' => $menu->type,
                'link' => $menu->link,
                'page_id' => $menu->page_id,
                'group_id' => $menu->group_id,
                'product_id' => $menu->product_id,
                'sub_menus' => $menus->orderBy('order', 'ASC')->where('parent_id', $menu->id)->get()
            ];
        }

        return $ar;
    }
}

if(!function_exists('getSlug')) {
    function getSlug($key, $menu) {
        if($key == 'parent') {
            if($menu['group_id'] != 0) {
                $groups = new \App\Models\ProductGroups;
                $slug = '/group/'.$groups->where('id', $menu['group_id'])->first()->slug;
            } else if($menu['product_id'] != 0) {
                $products = new \App\Models\Products;
                $slug = '/product/'.$products->where('id', $menu['product_id'])->first()->slug;
            } else if($menu['page_id'] != 0) {
                $pages = new \App\Models\Pages;
                $slug = '/page/'.$pages->where('id', $menu['page_id'])->first()->slug;
            } else {
                $slug = $menu['link'];
            }
        } else {
            $products = new \App\Models\Products;
            $slug = '/product/'.$products->where('id', $menu['product_id'])->first()->slug;
        }

        return $slug;
    }
}

if(!function_exists('getAttrValue')) {
    function getAttrValue($attr, $key) {
        $attrs = new \App\Models\Attributes;
        $attr = $attrs->where('id', $attr)->first();
        $result = json_decode($attr->options);

        return $result[$key];
    }
}


if(!function_exists('formatDate')) {
    function formatDate($date, $format = 'd-m-Y') {
        $carbon = new \Carbon\Carbon;

        return $carbon->parse($date)->format($format);
    }
}

if(!function_exists('slugtify')) {
    function slugtify($str) {
        $unicode = array(
            'a'=>'??|??|???|??|???|??|???|???|???|???|???|??|???|???|???|???|???',

            'd'=>'??',

            'e'=>'??|??|???|???|???|??|???|???|???|???|???',

            'i'=>'??|??|???|??|???',

            'o'=>'??|??|???|??|???|??|???|???|???|???|???|??|???|???|???|???|???',

            'u'=>'??|??|???|??|???|??|???|???|???|???|???',

            'y'=>'??|???|???|???|???',

            'A'=>'??|??|???|??|???|??|???|???|???|???|???|??|???|???|???|???|???',

            'D'=>'??',

            'E'=>'??|??|???|???|???|??|???|???|???|???|???',

            'I'=>'??|??|???|??|???',

            'O'=>'??|??|???|??|???|??|???|???|???|???|???|??|???|???|???|???|???',

            'U'=>'??|??|???|??|???|??|???|???|???|???|???',

            'Y'=>'??|???|???|???|???',
        );

        foreach($unicode as $nonUnicode=>$uni){
            $str = preg_replace("/($uni)/i", $nonUnicode, $str);
        }

        $str = str_replace(' ','_',$str);

        return $str;
    }
}

if(!function_exists('getProductDetail')) {
    function getProductDetail($id)
    {
        $product = new \App\Models\Products;

        return $product->where('id', $id)->first();
    }
}

if(!function_exists('getCartAttrs')) {
    function getCartAttrs($item)
    {
        $attrs = [];
        $attributes = new \App\Models\Attributes;

        foreach($item as $key => $value) {
            if(strpos($key, 'attr') !== false) {
                $id = str_replace('attr_', '', $key);
                $attr = $attributes->where('id', $id)->first();
                $attrs[] = ['id' => $id, 'name' => $attr->name, 'values' => json_decode($attr->options, true)[$value]];
            }
        }

        return $attrs;
    }
}

if(!function_exists('statistics')) {
    function statistics($start = '', $end = '')
    {
        if($start == '' && $end == '') {
            $start = new \Carbon\Carbon('first day of this month');
            $end = new \Carbon\Carbon('last day of this month');
        }

        $revenue = 0;
        $orders = \App\Models\Orders::where('status', 'completed')->whereBetween('created_at', [\Carbon\Carbon::parse($start), \Carbon\Carbon::parse($end)])->get();

        foreach($orders as $order) {
            foreach($order->detail as $detail) {
                $revenue = $revenue + $detail->price;
            }
        }

        $result = [
            'total_user' => \App\Models\User::count(),
            'total_order' => \App\Models\Orders::count(),
            'total_product' => \App\Models\Products::count(),
            'total_revenue' => $revenue ?? 0
        ];

        return (object)$result;
    }
}

if(!function_exists('generateOrderCode')) {
    function generateOrderCode($id, $type = 'NOR') {
        $id_length = strlen($id);
        $total_zero = '00000000';

        $format = substr($total_zero, -strlen($total_zero), -$id_length);

        return $type.$format.$id;
    }
}

if(!function_exists('formatStatus')) {
    function formatStatus($status) {
        $result = '';

        switch($status) {
            case 'completed':
                $result = '<span class="block rounded text-white bg-green-700 py-2 px-2">Ho??n t???t</span>';
            break;
            case 'pending':
                $result = '<span class="block rounded text-white bg-blue-700 py-2 px-2">Ch??? x??c nh???n</span>';
            break;
            case 'staff_received':
                $result = '<span class="block rounded text-white bg-blue-700 py-2 px-2">Nh??n vi??n nh???n ????n</span>';
            break;
            case 'processing':
                $result = '<span class="block rounded text-white bg-yellow-700 py-2 px-2">??ang x??? l??</span>';
            break;
            case 'waiting':
                $result = '<span class="block rounded text-white bg-yellow-700 py-2 px-2">Ch??? gi???y k???m</span>';
            break;
            default:
                $result = '<span class="block rounded text-white bg-red-700 py-2 px-2">???? h???y</span>';
        }

        return $result;
    }
}
