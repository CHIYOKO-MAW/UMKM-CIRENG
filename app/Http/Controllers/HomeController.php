<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Testimonial;

class HomeController extends Controller
{
    public function index()
    {
        $featuredProducts = Product::active()->featured()->orderBy('sort_order')->take(6)->get();
        $testimonials = Testimonial::active()->latest()->take(6)->get();

        return view('pages.landing', compact('featuredProducts', 'testimonials'));
    }

    public function menu()
    {
        $products = Product::active()->orderBy('category')->orderBy('sort_order')->get();
        $categories = $products->pluck('category')->unique()->values();

        return view('pages.menu', compact('products', 'categories'));
    }
}
