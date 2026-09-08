<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MetaEventMapping;
use App\Services\MetaEventCatalog;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class MetaEventMappingController extends Controller
{
    public function store(Request $request, MetaEventCatalog $catalog): RedirectResponse
    {
        $data = $this->validated($request, $catalog);
        $data['is_active'] = $request->boolean('is_active');
        MetaEventMapping::create($data);

        return back()->with('success', 'Mapping event Meta ditambahkan.');
    }

    public function update(Request $request, MetaEventMapping $mapping, MetaEventCatalog $catalog): RedirectResponse
    {
        $data = $this->validated($request, $catalog, $mapping);
        $data['is_active'] = $request->boolean('is_active');
        $mapping->update($data);

        return back()->with('success', 'Mapping event Meta diperbarui.');
    }

    public function destroy(MetaEventMapping $mapping): RedirectResponse
    {
        $mapping->delete();

        return back()->with('success', 'Mapping event Meta dihapus. Event tersebut tidak akan dikirim lagi.');
    }

    private function validated(Request $request, MetaEventCatalog $catalog, ?MetaEventMapping $mapping = null): array
    {
        $uniqueMapping = Rule::unique('meta_event_mappings')->where(fn ($query) => $query
            ->where('event_name', $request->input('event_name'))
            ->where('trigger_type', $request->input('trigger_type')));

        if ($mapping) {
            $uniqueMapping->ignore($mapping);
        }

        $data = $request->validate([
            'event_name' => ['required', Rule::in(array_keys(MetaEventCatalog::EVENTS))],
            'trigger_type' => ['required', Rule::in(array_keys(MetaEventCatalog::TRIGGERS))],
            'target_key' => [
                'required',
                'string',
                'max:150',
                $uniqueMapping,
            ],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $target = $catalog->target($data['target_key']);
        if (! $target || $target['trigger'] !== $data['trigger_type']) {
            throw ValidationException::withMessages([
                'target_key' => 'Target tidak tersedia untuk jenis pemicu yang dipilih.',
            ]);
        }

        return $data;
    }
}
