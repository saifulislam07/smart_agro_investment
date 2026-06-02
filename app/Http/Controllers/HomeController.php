<?php

namespace App\Http\Controllers;

use App\Models\Faq;
use App\Models\Post;
use App\Models\Product;
use App\Models\Project;
use App\Models\Property;
use App\Models\Testimonial;

class HomeController extends Controller
{
    public function __invoke()
    {
        $projects = Project::query()->latest()->get();
        $properties = Property::query()->latest()->take(4)->get();
        $products = Product::query()->latest()->take(6)->get();
        $posts = Post::query()->latest('published_at')->take(3)->get();
        $faqs = Faq::query()->orderBy('sort_order')->get();
        $testimonials = Testimonial::query()->latest()->get();

        $stats = [
            ['value' => 'BDT 1 Billion++', 'label' => 'Fund Disburse'],
            ['value' => 'BDT 1 Billion++', 'label' => 'Fund Reimburse'],
            ['value' => '12000++', 'label' => 'Farmers Engaged'],
            ['value' => '100k+', 'label' => 'Farm Produce Sold (Tons)'],
            ['value' => '33+', 'label' => 'Years of Service'],
        ];

        $certifications = [
            'Established in 2003',
            'RJSC Certificate of Incorporation No C-195903',
            'DCCI ECNGRO202507001532',
            'BIDA License No L-202508060017189-H',
            'DNCC Trade License No TRAD/DNCC/006823',
            'D&B D-U-N-S Number 77-411-5707',
        ];

        $categories = [
            'Banana', 'Biofloc Fish Farming', 'Capsicum', 'Cattle Ranch', 'Chicken', 'Corn',
            'Date Molasses Export', 'Dry Fish', 'G9 Banana', 'Goat', 'Honey Export', 'Mango Export',
            'Mixed Vegetables', 'Mushroom', 'Mustard Oil', 'Paddy', 'Papaya', 'Qurbani', 'Sweet Pumpkin',
        ];

        return view('home', compact(
            'projects',
            'properties',
            'products',
            'posts',
            'faqs',
            'testimonials',
            'stats',
            'certifications',
            'categories'
        ));
    }
}
