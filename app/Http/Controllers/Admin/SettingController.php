<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\View\View;

class SettingController extends Controller
{
    /**
     * Show the website settings edit form.
     */
    public function edit(): View
    {
        $settings = Setting::getAll();

        return view('admin.settings.edit', compact('settings'));
    }

    /**
     * Update the website settings.
     */
    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'site_name' => ['nullable', 'string', 'max:255'],
            'site_tagline' => ['nullable', 'string', 'max:255'],
            'header_logo' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp,svg', 'max:2048'],
            'footer_logo' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp,svg', 'max:2048'],
            'favicon' => ['nullable', 'file', 'mimes:ico,png,jpg,svg', 'max:1024'],
            'contact_email' => ['nullable', 'email', 'max:255'],
            'contact_phone' => ['nullable', 'string', 'max:50'],
            'contact_address' => ['nullable', 'string', 'max:500'],
            'contact_map_iframe' => ['nullable', 'string'],
            'social_facebook' => ['nullable', 'url', 'max:255'],
            'social_twitter' => ['nullable', 'url', 'max:255'],
            'social_linkedin' => ['nullable', 'url', 'max:255'],
            'social_youtube' => ['nullable', 'url', 'max:255'],
            'social_instagram' => ['nullable', 'url', 'max:255'],
            'footer_about_text' => ['nullable', 'string', 'max:1000'],
            'footer_copyright' => ['nullable', 'string', 'max:255'],
            'default_meta_title' => ['nullable', 'string', 'max:255'],
            'default_meta_description' => ['nullable', 'string', 'max:500'],
            'default_meta_keywords' => ['nullable', 'string', 'max:255'],
            'default_og_image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'google_analytics_id' => ['nullable', 'string', 'max:100'],
            'google_search_console_code' => ['nullable', 'string', 'max:255'],
        ]);

        $fileKeys = ['header_logo', 'footer_logo', 'favicon', 'default_og_image'];

        foreach ($fileKeys as $fileKey) {
            if ($request->hasFile($fileKey)) {
                $oldFile = Setting::get($fileKey);
                if ($oldFile && File::exists(public_path($oldFile))) {
                    File::delete(public_path($oldFile));
                }

                $fileName = time().'_'.$fileKey.'_'.uniqid().'.'.$request->file($fileKey)->getClientOriginalExtension();
                $request->file($fileKey)->move(public_path('uploads/settings'), $fileName);
                $validated[$fileKey] = 'uploads/settings/'.$fileName;
            } else {
                unset($validated[$fileKey]);
            }
        }

        foreach ($validated as $key => $value) {
            Setting::set($key, $value);
        }

        return redirect()->route('admin.settings.edit')
            ->with('success', 'ওয়েবসাইট সেটিংস সফলভাবে সংরক্ষিত হয়েছে!');
    }
}
