<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Media;
use App\Models\Setting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\View\View;

class BrandingSettingController extends Controller
{
    public function edit(): View
    {
        $settings = Setting::groupValues('branding');
        return view('admin.settings.branding', compact('settings'));
    }

    public function update(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'logo_url' => ['nullable', 'string', 'max:500'],
            'favicon_url' => ['nullable', 'string', 'max:500'],
            'app_icon_url' => ['nullable', 'string', 'max:500'],
            'logo' => ['nullable', 'file', 'mimes:png,jpg,jpeg,webp,svg', 'max:4096'],
            'favicon' => ['nullable', 'file', 'mimes:png,webp,svg,ico', 'max:2048'],
            'app_icon' => ['nullable', 'file', 'mimes:png,jpg,jpeg,webp', 'max:4096'],
        ]);

        foreach (['logo_url', 'favicon_url', 'app_icon_url'] as $key) {
            Setting::put('branding', $key, $data[$key] ?? null);
        }

        foreach (['logo' => 'logo_url', 'favicon' => 'favicon_url', 'app_icon' => 'app_icon_url'] as $field => $key) {
            if ($request->hasFile($field)) {
                Setting::put('branding', $key, $this->storeAsset($request->file($field), $field));
            }
        }

        return back()->with('success', 'Logo dan icon website berhasil diperbarui.');
    }

    private function storeAsset(UploadedFile $file, string $type): string
    {
        $path = $file->store('temoe-tumbuh/branding', 'public');

        Media::create([
            'disk' => 'public',
            'path' => $path,
            'original_name' => $file->getClientOriginalName(),
            'mime_type' => $file->getMimeType(),
            'size' => $file->getSize(),
            'alt_text' => 'Temoe Tumbuh '.$type,
        ]);

        return '/storage/'.$path;
    }
}
