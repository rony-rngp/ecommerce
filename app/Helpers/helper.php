<?php

function get_settings($key){
    $config = null;
    $data = collect(app('app_settings'))->where('key', $key)->first();
    if (isset($data) && $data != null){
        $config = json_decode($data['value'], true);
        if (is_null($config)) {
            $config = $data['value'];
        }
    }
    return $config;
}

function pagination_limit(){
    return 25;
}

function base_currency(){
    return get_settings('currency_symbol').' ';
}

function upload_image($dir, $image = null){
    if ($image != null) {
        $ext = $image->getClientOriginalExtension();
        $imageName = \Carbon\Carbon::now()->toDateString() . "-" . uniqid() . "." . $ext;
        if (!\Illuminate\Support\Facades\Storage::disk('public')->exists($dir)) {
            \Illuminate\Support\Facades\Storage::disk('public')->makeDirectory($dir);
        }
        \Illuminate\Support\Facades\Storage::disk('public')->put($dir . $imageName, file_get_contents($image));
    } else {
        $imageName = '';
    }
    return $dir.$imageName;
}

function update_image( $dir, $old_image, $image = null){
    if ($old_image != '' && \Illuminate\Support\Facades\Storage::disk('public')->exists( $old_image)) {
        \Illuminate\Support\Facades\Storage::disk('public')->delete($old_image);
    }
    $imageName = upload_image($dir, $image);
    return $imageName;
}

function delete_image($full_path){
    if ($full_path != '' && \Illuminate\Support\Facades\Storage::disk('public')->exists($full_path)) {
        \Illuminate\Support\Facades\Storage::disk('public')->delete($full_path);
    }
}

function check_image($image = null){
   if( $image != '' && Storage::disk('public')->exists($image)){
       return true;
   }else{
       return false;
   }
}


