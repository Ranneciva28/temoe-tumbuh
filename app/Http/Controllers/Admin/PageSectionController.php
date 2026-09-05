<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Media;
use App\Models\PageSection;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PageSectionController extends Controller
{
    public function index(): View
    {
        $sections = PageSection::query()->where('page', 'home')->orderBy('sort_order')->get();
        return view('admin.cms.index', compact('sections'));
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validateSection($request);
        $data['page'] = 'home';
        $data['section_key'] = $data['section_key'] ?: 'section_'.str()->lower(str()->random(8));
        $data['is_active'] = $request->boolean('is_active');
        $this->attachImage($request, $data);
        PageSection::create($data);

        return back()->with('success', 'Section homepage ditambahkan.');
    }

    public function update(Request $request, PageSection $section): RedirectResponse
    {
        $data = $this->validateSection($request, false);
        $data['is_active'] = $request->boolean('is_active');
        $this->attachImage($request, $data);
        $section->update($data);

        return back()->with('success', 'Section homepage diperbarui.');
    }

    public function destroy(PageSection $section): RedirectResponse
    {
        $section->delete();
        return back()->with('success', 'Section homepage dihapus.');
    }

    private function validateSection(Request $request, bool $requireKey = true): array
    {
        return $request->validate([
            'section_key' => [$requireKey ? 'required' : 'sometimes', 'nullable', 'string', 'max:100'],
            'title' => ['nullable', 'string', 'max:255'],
            'subtitle' => ['nullable', 'string', 'max:500'],
            'content' => ['nullable', 'string', 'max:10000'],
            'image_path' => ['nullable', 'string', 'max:500'],
            'image' => ['nullable', 'file', 'mimes:jpg,jpeg,png,webp,gif', 'max:8192'],
            'cta_label' => ['nullable', 'string', 'max:100'],
            'cta_url' => ['nullable', 'string', 'max:500'],
            'sort_order' => ['nullable', 'integer', 'min:0', 'max:9999'],
            'is_active' => ['nullable', 'boolean'],
        ]);
    }

    private function attachImage(Request $request, array &$data): void
    {
        unset($data['image']);

        if (! $request->hasFile('image')) return;

        $file = $request->file('image');
        $path = $file->store('temoe-tumbuh/homepage', 'public');
        $data['image_path'] = '/storage/'.$path;

        Media::create([
            'disk' => 'public',
            'path' => $path,
            'original_name' => $file->getClientOriginalName(),
            'mime_type' => $file->getMimeType(),
            'size' => $file->getSize(),
            'alt_text' => $data['title'] ?? null,
        ]);
    }
}
