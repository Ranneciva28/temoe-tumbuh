<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Lead;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;

class LeadController extends Controller
{
    public function index(Request $request): View
    {
        $query = Lead::query()->latest();

        if ($search = trim((string) $request->query('q'))) {
            $query->where(function ($q) use ($search) {
                $q->where('parent_name', 'like', "%{$search}%")
                    ->orWhere('whatsapp', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('city', 'like', "%{$search}%")
                    ->orWhere('district', 'like', "%{$search}%");
            });
        }

        if ($status = $request->query('status')) {
            $query->where('status', $status);
        }

        if ($source = $request->query('source')) {
            $source === 'direct'
                ? $query->whereNull('utm_source')
                : $query->where('utm_source', $source);
        }

        $leads = $query->paginate(30)->withQueryString();
        $sources = Lead::query()->whereNotNull('utm_source')->distinct()->orderBy('utm_source')->pluck('utm_source');

        return view('admin.leads.index', compact('leads', 'sources'));
    }

    public function show(Lead $lead): View
    {
        return view('admin.leads.show', compact('lead'));
    }

    public function update(Request $request, Lead $lead): RedirectResponse
    {
        $data = $request->validate([
            'status' => ['required', 'in:new,contacted,qualified,high_intent,reserved,lost'],
            'notes' => ['nullable', 'string', 'max:5000'],
        ]);

        $oldStatus = $lead->status;
        $lead->fill($data);

        if ($oldStatus !== $data['status']) {
            if ($data['status'] === 'contacted' && ! $lead->contacted_at) $lead->contacted_at = now();
            if (in_array($data['status'], ['qualified','high_intent','reserved'], true) && ! $lead->qualified_at) $lead->qualified_at = now();
            if ($data['status'] === 'reserved' && ! $lead->reserved_at) $lead->reserved_at = now();
        }

        $lead->save();

        return back()->with('success', 'Lead berhasil diperbarui.');
    }

    public function export(Request $request): Response
    {
        $leads = Lead::query()->latest()->get();
        $columns = [
            'id','parent_name','whatsapp','email','child_name','child_age','city','district',
            'preferred_location','preferred_schedule','preferred_start_date','budget_range',
            'reservation_interest','status','utm_source','utm_medium','utm_campaign','utm_content',
            'utm_term','fbclid','gclid','created_at',
        ];

        $handle = fopen('php://temp', 'r+');
        fputcsv($handle, $columns);
        foreach ($leads as $lead) {
            fputcsv($handle, array_map(fn ($column) => data_get($lead, $column), $columns));
        }
        rewind($handle);
        $csv = stream_get_contents($handle);
        fclose($handle);

        return response($csv, 200, [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="temoe-tumbuh-leads-'.now()->format('Ymd-His').'.csv"',
        ]);
    }
}
