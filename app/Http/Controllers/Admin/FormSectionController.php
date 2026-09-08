<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FormField;
use App\Models\FormSection;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class FormSectionController extends Controller
{
    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'section_key' => [
                'required',
                'regex:/^[a-z0-9_]+$/',
                'max:100',
                Rule::unique('form_sections', 'section_key')
                    ->where(fn ($query) => $query->where('form_key', 'interest')),
            ],
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:1000'],
            'sort_order' => ['nullable', 'integer', 'min:0', 'max:9999'],
            'is_active' => ['nullable', 'boolean'],
        ], [
            'section_key.unique' => 'Section key tersebut sudah dipakai pada Form Minat.',
        ]);

        $data['form_key'] = 'interest';
        $data['sort_order'] = $data['sort_order'] ?? 0;
        $data['is_active'] = $request->boolean('is_active');
        $data['is_protected'] = false;
        FormSection::create($data);

        return back()->with('success', 'Section Form Minat ditambahkan. Sekarang Moms bisa menambahkan pertanyaan ke section tersebut.');
    }

    public function update(Request $request, FormSection $section): RedirectResponse
    {
        $this->ensureInterestSection($section);

        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:1000'],
            'sort_order' => ['nullable', 'integer', 'min:0', 'max:9999'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $data['sort_order'] = $data['sort_order'] ?? 0;
        $data['is_active'] = $section->is_protected ? true : $request->boolean('is_active');
        $section->update($data);

        return back()->with('success', 'Section Form Minat diperbarui.');
    }

    public function destroy(FormSection $section): RedirectResponse
    {
        $this->ensureInterestSection($section);

        if ($section->is_protected) {
            return back()->withErrors([
                'section' => 'Section data orang tua dan persetujuan tidak dapat dihapus karena wajib untuk menyimpan lead dengan aman.',
            ]);
        }

        DB::transaction(function () use ($section) {
            FormField::query()
                ->where('form_key', 'interest')
                ->where('section_key', $section->section_key)
                ->delete();
            $section->delete();
        });

        return back()->with('success', 'Section dan pertanyaan di dalamnya dihapus. Jawaban historis pada lead tetap tersimpan.');
    }

    private function ensureInterestSection(FormSection $section): void
    {
        abort_unless($section->form_key === 'interest', 404);
    }
}
