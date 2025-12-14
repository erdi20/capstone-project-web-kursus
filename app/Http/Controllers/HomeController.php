<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    // app/Http/Controllers/HomeController.php

    public function index()
    {
        $sliders = \App\Models\Slider::where('is_active', true)
            ->orderBy('order')
            ->take(5)
            ->get();

        return view('dashboard', compact('sliders'));
    }
}
