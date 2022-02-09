<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Cache;

class ManageSiteController extends Controller
{
    public function contact_us_view() {
        $data = json_decode(Cache::get('cache_contact_us'),true);
     
        return view('admin.manage-site.contact-us', compact('data'));
    }

    public function updateContactUs() {
      
        $img_path = "";
        if(request()->hasFile('image')){       
            $folder_to_save = 'page-assets';
            $image_name = uniqid() . "." . request()->image->extension();
            request()->image->move(public_path('images/' . $folder_to_save), $image_name);
            $img_path = $folder_to_save . "/" . $image_name;
        }

        $data = json_decode(Cache::get('cache_contact_us'),true);

        if (strlen($img_path) > 0 && !$img_path ) {
            $img_path = $data['image'];
        }

        $data = array(
            "location" => request()->location,
            "phone_number" => request()->phone_number,
            "email" => request()->email,
            "image" => $img_path,
        );

        Cache::put('cache_contact_us', json_encode($data));

        return redirect()->back()->with('success', 'Data was saved successfully.');
    }

    public function footer_view() {
        $data = json_decode(Cache::get('cache_footer'),true);
     
        return view('admin.manage-site.footer', compact('data'));
    }

    public function updateFooter() {

        $data = array(
            "facebook" => request()->facebook,
            "instagram" => request()->instagram,
            "tiktok" => request()->tiktok,
            "store" => request()->store,
            "copyright" => request()->copyright,
        );

        Cache::put('cache_footer', json_encode($data));

        return redirect()->back()->with('success', 'Data was saved successfully.');
    }

    public function about_us_view() {
        $data = json_decode(Cache::get('cache_about_us'),true);
     
        return view('admin.manage-site.about-us', compact('data'));
    }

    public function updateAboutUs() {
        
        $img_path = "";
        if(request()->hasFile('image')){       
            $folder_to_save = 'page-assets';
            $image_name = uniqid() . "." . request()->image->extension();
            request()->image->move(public_path('images/' . $folder_to_save), $image_name);
            $img_path = $folder_to_save . "/" . $image_name;
        }

        $data = json_decode(Cache::get('cache_about_us'),true);

        if (strlen($img_path) > 0 && !$img_path ) {
            $img_path = $data['image'];
        }

        $data = array(
            "about_text" => request()->about_text,
            "image" => $img_path,
            "display_image" => request()->display_image,
        );

        Cache::put('cache_about_us', json_encode($data));

        return redirect()->back()->with('success', 'Data was saved successfully.');
    }


    public function terms_cond_view() {
        return view('admin.manage-site.terms-and-cond');
    }

    public function updateTermsAndCond() {

        Cache::put('cache_terms_and_cond', request()->terms_and_cond);

        return redirect()->back()->with('success', 'Data was saved successfully.');
    }
}
