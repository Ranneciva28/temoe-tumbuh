<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Lead;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __invoke(): View
    {
        $total = Lead::count();
        $qualified = Lead::whereIn('status', ['qualified','high_intent','reserved'])->count();
        $highIntent = Lead::whereIn('status', ['high_intent','reserved'])->count();
        $reserved = Lead::where('status', 'reserved')->count();
        $reservationInterest = Lead::where('reservation_interest', true)->count();

        $byCity = Lead::query()
            ->selectRaw("COALESCE(NULLIF(city,''), 'Belum diisi') as label, COUNT(*) as total")
            ->groupBy('label')
            ->orderByDesc('total')
            ->limit(8)
            ->get();

        $bySource = Lead::query()
            ->selectRaw("COALESCE(NULLIF(utm_source,''), 'direct') as label, COUNT(*) as total")
            ->groupBy('label')
            ->orderByDesc('total')
            ->limit(8)
            ->get();

        $byBudget = Lead::query()
            ->selectRaw("COALESCE(NULLIF(budget_range,''), 'Belum diisi') as label, COUNT(*) as total")
            ->groupBy('label')
            ->orderByDesc('total')
            ->limit(8)
            ->get();

        $recentLeads = Lead::latest()->limit(8)->get();

        return view('admin.index', compact(
            'total','qualified','highIntent','reserved','reservationInterest',
            'byCity','bySource','byBudget','recentLeads'
        ));
    }
}
