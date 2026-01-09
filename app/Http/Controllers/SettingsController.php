<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Setting;

class SettingsController extends Controller
{
    public function index()
    {
        $settings = Setting::all()->pluck('value', 'key')->toArray();
        return view('admin.settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        // Handle standard simple fields
        $fields = ['site_phone', 'site_email', 'site_address', 'site_name', 'site_currency'];
        foreach($fields as $field) {
            Setting::updateOrCreate(['key' => $field], ['value' => $request->input($field)]);
        }

        // Handle JSON fields (Social & Menu)
        // We expect raw JSON strings or arrays from the form. For simplicity, we decode/encode to ensure validity or just save raw if validated.
        // PRO TIP: In a real app, complex builders would submit JSON. Here we'll handle simple text inputs that we format as JSON or direct array inputs.
        
        // Social Logic: reconstruct array from inputs
        if ($request->has('social_platform')) {
            $platforms = $request->input('social_platform');
            $urls = $request->input('social_url');
            $socialLinks = [];
            foreach ($platforms as $index => $platform) {
                if(!empty($platform)) {
                    $socialLinks[] = [
                        'platform' => $platform,
                        'url' => $urls[$index] ?? '#',
                        'icon' => strtolower($platform) // simple icon mapping
                    ];
                }
            }
            Setting::updateOrCreate(['key' => 'social_links'], ['value' => json_encode($socialLinks), 'type' => 'json']);
        }

        // Menu Logic: reconstruct array from inputs
        if ($request->has('menu_label')) {
            $labels = $request->input('menu_label');
            $urls = $request->input('menu_url');
            $menuItems = [];
            foreach ($labels as $index => $label) {
                if(!empty($label)) {
                    $menuItems[] = [
                        'label' => $label,
                        'url' => $urls[$index] ?? '#',
                        'type' => 'link'
                    ];
                }
            }
            Setting::updateOrCreate(['key' => 'main_menu'], ['value' => json_encode($menuItems), 'type' => 'json']);
        }

        return redirect()->back()->with('success', 'Settings updated successfully!');
    }
}
