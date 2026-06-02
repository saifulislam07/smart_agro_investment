<?php

namespace App\Http\Controllers;

use App\Models\Faq;
use App\Models\Post;
use App\Models\Product;
use App\Models\Property;
use App\Models\Testimonial;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PageController extends Controller
{
    public function about()
    {
        $testimonials = Testimonial::latest()->get();

        return view('pages.about', compact('testimonials'));
    }

    public function terms()
    {
        return view('pages.terms');
    }

    public function properties()
    {
        $properties = Property::latest()->get();

        return view('pages.properties', compact('properties'));
    }

    public function products(Request $request)
    {
        $categories = Product::distinct()->orderBy('category')->pluck('category');
        $products = Product::query()
            ->when($request->filled('category'), fn ($query) => $query->where('category', $request->string('category')))
            ->latest()
            ->get();

        return view('pages.products', compact('products', 'categories'));
    }

    public function ngoActivities()
    {
        $activities = $this->activities();

        return view('pages.activities', compact('activities'));
    }

    public function ngoActivityShow(string $slug)
    {
        $activity = $this->activities()->firstWhere('slug', $slug);
        abort_unless($activity, 404);

        $related = $this->activities()->where('slug', '!=', $slug)->take(3);

        return view('pages.activity-show', compact('activity', 'related'));
    }

    public function news()
    {
        $posts = Post::where('type', 'News')->latest('published_at')->get();

        return view('pages.news', compact('posts'));
    }

    public function newsShow(Post $post)
    {
        abort_unless($post->type === 'News', 404);

        $related = Post::where('type', 'News')->whereKeyNot($post->id)->latest('published_at')->take(3)->get();

        return view('pages.news-show', compact('post', 'related'));
    }

    public function blogs()
    {
        $posts = Post::where('type', 'Blog')->latest('published_at')->get();
        $extraBlogs = collect();

        return view('pages.blogs', compact('posts', 'extraBlogs'));
    }

    public function blogShow(Post $post)
    {
        abort_unless($post->type === 'Blog', 404);

        $related = Post::where('type', 'Blog')->whereKeyNot($post->id)->latest('published_at')->take(3)->get();

        return view('pages.blog-show', compact('post', 'related'));
    }

    public function refund()
    {
        return view('pages.refund');
    }

    public function delivery()
    {
        return view('pages.delivery');
    }

    public function privacy()
    {
        return view('pages.privacy');
    }

    public function risk()
    {
        return view('pages.risk');
    }

    public function faq()
    {
        $faqs = Faq::orderBy('sort_order')->get();

        return view('pages.faq', compact('faqs'));
    }

    private function activities()
    {
        return collect([
            ['title' => 'Agricultural Funding Smart Agro Project by Krishi Association', 'date' => 'DEC 28 / 25', 'image' => 'https://images.unsplash.com/photo-1592982537447-7440770cbfc9?auto=format&fit=crop&w=900&q=80', 'excerpt' => 'Field-level funding support for farmers with transparent supervision and seasonal planning.'],
            ['title' => 'Sustainable Fishery Development Project', 'date' => 'DEC 28 / 25', 'image' => 'https://images.unsplash.com/photo-1529230117010-b6c436154f25?auto=format&fit=crop&w=900&q=80', 'excerpt' => 'A fisheries initiative focused on better inputs, pond management, and market linkage.'],
            ['title' => 'Fair Trade in Agriculture Project', 'date' => 'DEC 28 / 25', 'image' => 'https://images.unsplash.com/photo-1595855759920-86582396756a?auto=format&fit=crop&w=900&q=80', 'excerpt' => 'Supporting farmers with fairer pricing, organized collection, and buyer coordination.'],
            ['title' => 'Agricultural Empowerment Project: Right Seeds and Pesticides Supply', 'date' => 'DEC 28 / 25', 'image' => 'https://images.unsplash.com/photo-1523348837708-15d4a09cfac2?auto=format&fit=crop&w=900&q=80', 'excerpt' => 'Ensuring timely access to verified seeds, crop protection, and field guidance.'],
            ['title' => 'Asil Chicken Farm Project', 'date' => 'DEC 28 / 25', 'image' => 'https://images.unsplash.com/photo-1548550023-2bdb3c5beed7?auto=format&fit=crop&w=900&q=80', 'excerpt' => 'Training and operational support for poultry entrepreneurs in rural communities.'],
            ['title' => 'Entrepreneurship Development Project', 'date' => 'DEC 28 / 25', 'image' => 'https://images.unsplash.com/photo-1500937386664-56d1dfef3854?auto=format&fit=crop&w=900&q=80', 'excerpt' => 'Helping rural entrepreneurs develop business discipline, records, and market access.'],
        ])->map(fn ($activity) => $activity + [
            'slug' => Str::slug($activity['title']),
            'content' => 'This Smart Agro NGO activity focuses on practical support, field monitoring, community participation, and measurable outcomes. The program connects rural households with better planning, stronger inputs, and market access while keeping transparency at the center of every step.',
        ]);
    }
}
