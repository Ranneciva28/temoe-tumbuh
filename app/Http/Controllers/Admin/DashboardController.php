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

        return view('admin.index', compact('total','qualified','highIntent','reserved'));
    }
}
