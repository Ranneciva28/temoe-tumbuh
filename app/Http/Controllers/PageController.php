<?php

namespace App\Http\Controllers;

use App\Models\PageSection;
use App\Models\Setting;
use Illuminate\View\View;

class PageController extends Controller
{
    public function home(): View
    {
        $sections = PageSection::query()
            ->where('page', 'home')
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->get();

        return view('home', [
            'sections' => $sections,
            'tracking' => Setting::groupValues('tracking'),
        ]);
    }
}
