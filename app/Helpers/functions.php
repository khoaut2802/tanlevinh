<?php
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
        $list = $menus->where('parent_id', 0)->orderBy('order', 'ASC')->get();
        $ar = [];

        foreach($list as $menu) {
            $ar[] = [
                'id'   => $menu->id,
                'name' => $menu->name,
                'slug' => $menu->slug,
                'sub_menus' => $menus->orderBy('order', 'ASC')->where('parent_id', $menu->id)->get() ?? []
            ];
        }

        return $ar;
    }
}


if(!function_exists('formatDate')) {
    function formatDate($date, $format = 'd-m-Y') {
        $carbon = new \Carbon\Carbon;

        return $carbon->parse($date)->format($format);
    }
}