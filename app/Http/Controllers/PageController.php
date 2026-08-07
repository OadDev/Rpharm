<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Certification;
use App\Models\Milestone;
use App\Models\Product;
use App\Models\ProcessStep;
use App\Models\Stat;
use App\Models\Testimonial;
use App\Models\UspItem;
use App\Models\ValueProp;
use Illuminate\View\View;

class PageController extends Controller
{
    public function home(): View
    {
        return view('home', [
            'uspItems' => UspItem::orderBy('sort_order')->get(),
            'categories' => Category::orderBy('sort_order')->get(),
            'featuredProducts' => Product::with('category')->where('is_featured', true)->orderBy('sort_order')->get(),
            'homeStats' => Stat::where('page', 'home')->orderBy('sort_order')->get(),
            'testimonials' => Testimonial::where('show_on_home', true)->orderBy('sort_order')->get(),
        ]);
    }

    public function about(): View
    {
        return view('about', [
            'aboutStats' => Stat::where('page', 'about')->orderBy('sort_order')->get(),
            'valueProps' => ValueProp::orderBy('sort_order')->get(),
            'milestones' => Milestone::orderBy('sort_order')->get(),
            'certifications' => Certification::orderBy('sort_order')->get(),
            'testimonials' => Testimonial::where('show_on_about', true)->orderBy('sort_order')->get(),
        ]);
    }

    public function process(): View
    {
        return view('process', [
            'steps' => ProcessStep::orderBy('sort_order')->get(),
        ]);
    }
}
