<?php

namespace Database\Seeders;

use App\Models\Faq;
use App\Models\Investment;
use App\Models\Post;
use App\Models\Product;
use App\Models\Project;
use App\Models\Property;
use App\Models\Testimonial;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        Investment::query()->delete();
        Project::query()->delete();
        Property::query()->delete();
        Product::query()->delete();
        Post::query()->delete();
        Faq::query()->delete();
        Testimonial::query()->delete();
        User::query()->delete();

        $projects = [
            [
                'title' => 'Cultivated Crop Land Mango-4',
                'category' => 'Cultivated Crop Land-SP',
                'business_type' => 'Ownership',
                'status' => 'Collecting Investment',
                'investment_time' => '10 Days',
                'duration' => '36 Month(s)',
                'start_date' => '2026-05-14',
                'mature_date' => '2029-05-13',
                'goal' => 52350000,
                'minimum_investment' => 350000,
                'raised' => 33909800,
                'roi' => 'Annually 41%',
                'is_live' => true,
                'image' => 'https://images.unsplash.com/photo-1601493700631-2b16ec4b4716?auto=format&fit=crop&w=900&q=80',
                'summary' => 'Long-term mango orchard ownership project with farm supervision, harvest planning, and structured investor reporting.',
            ],
            [
                'title' => 'Sweet Pumpkin-4',
                'category' => 'Sweet Pumpkin',
                'business_type' => 'Production & Trading',
                'status' => 'Collecting Investment',
                'investment_time' => '2 Days',
                'duration' => '4 Month(s)',
                'start_date' => '2026-05-06',
                'mature_date' => '2026-09-05',
                'goal' => 13150000,
                'minimum_investment' => 17500,
                'raised' => 13145953.77,
                'roi' => 'Annually 38%',
                'is_live' => true,
                'image' => 'https://images.unsplash.com/photo-1509622905150-fa66d3906e09?auto=format&fit=crop&w=900&q=80',
                'summary' => 'Short-cycle pumpkin production and trading project focused on quick harvest turnover and market access.',
            ],
            [
                'title' => 'Qurbani Goat-4',
                'category' => 'Qurbani',
                'business_type' => 'Trading',
                'status' => 'Collecting Investment',
                'investment_time' => '2 Days',
                'duration' => '2 Month(s)',
                'start_date' => '2026-05-06',
                'mature_date' => '2026-07-05',
                'goal' => 21250700,
                'minimum_investment' => 21500,
                'raised' => 21250591.48,
                'roi' => 'Annually 36%',
                'is_live' => true,
                'image' => 'https://images.unsplash.com/photo-1524024973431-2ad916746881?auto=format&fit=crop&w=900&q=80',
                'summary' => 'Seasonal livestock trading project built around Qurbani demand, procurement discipline, and transparent sales tracking.',
            ],
            [
                'title' => 'Banana-5',
                'category' => 'Banana',
                'business_type' => 'Trading',
                'status' => 'Collecting Investment',
                'investment_time' => '2 Days',
                'duration' => '6 Month(s)',
                'start_date' => '2026-05-06',
                'mature_date' => '2026-11-05',
                'goal' => 13800000,
                'minimum_investment' => 20750,
                'raised' => 13300429.23,
                'roi' => 'Annually 40%',
                'is_live' => true,
                'image' => 'https://images.unsplash.com/photo-1528825871115-3581a5387919?auto=format&fit=crop&w=900&q=80',
                'summary' => 'Banana trading project connecting farmers, collection points, and wholesale buyers under one managed pipeline.',
            ],
            [
                'title' => 'Royal Ghee-3',
                'category' => 'Ghee',
                'business_type' => 'Production & Trading',
                'status' => 'Running',
                'investment_time' => 'Investment Closed',
                'duration' => '2 Month(s)',
                'start_date' => '2026-04-14',
                'mature_date' => '2026-06-13',
                'goal' => 19250720,
                'minimum_investment' => 25700,
                'raised' => 19250493.24,
                'roi' => 'Annually 36%',
                'is_live' => false,
                'image' => 'https://images.unsplash.com/photo-1628088062854-d1870b4553da?auto=format&fit=crop&w=900&q=80',
                'summary' => 'Value-added dairy project for ghee production, quality control, packaging, and retail distribution.',
            ],
            [
                'title' => 'Mushroom',
                'category' => 'Mushroom',
                'business_type' => 'Production & Trading',
                'status' => 'Running',
                'investment_time' => 'Investment Closed',
                'duration' => '4 Month(s)',
                'start_date' => '2026-04-14',
                'mature_date' => '2026-08-13',
                'goal' => 19800000,
                'minimum_investment' => 20200,
                'raised' => 19968668.54,
                'roi' => 'Annually 38%',
                'is_live' => false,
                'image' => 'https://images.unsplash.com/photo-1504545102780-26774c1bb073?auto=format&fit=crop&w=900&q=80',
                'summary' => 'Controlled-environment mushroom production with predictable cycles, training support, and buyer alignment.',
            ],
        ];

        foreach ($projects as $project) {
            Project::create($project + [
                'slug' => Str::slug($project['title']),
                'description' => 'This managed project combines field supervision, procurement discipline, farmer support, and buyer coordination. Investors can compare the project timeline, funding goal, ROI, and maturity date before submitting an amount.',
                'market_opportunity' => 'Bangladesh has strong domestic demand for quality agricultural products. Better planning, collection, grading, and trading can improve margins while reducing waste across the supply chain.',
                'risk_factors' => 'Agriculture projects may face weather changes, disease, price fluctuation, logistics issues, and operational delays. Smart Agro reduces these risks through monitoring, reporting, and diversified project planning.',
                'gallery' => [
                    $project['image'],
                    'https://images.unsplash.com/photo-1499529112087-3cb3b73cec95?auto=format&fit=crop&w=900&q=80',
                    'https://images.unsplash.com/photo-1516253593875-bd7ba052fbc9?auto=format&fit=crop&w=900&q=80',
                ],
            ]);
        }

        foreach ([
            ['title' => 'The Royal Agro', 'type' => 'Eco-Tourism', 'location' => 'North Bengal', 'price_range' => 'BDT 8.5L - 22L', 'roi' => 'Projected 18%', 'image' => 'https://images.unsplash.com/photo-1500530855697-b586d89ba3ee?auto=format&fit=crop&w=900&q=80', 'summary' => 'Agro-resort land investment blended with tourism, orchards, and rural experience zones.'],
            ['title' => 'ROSA Hi Tech City', 'type' => 'Commercial', 'location' => 'Dhaka Region', 'price_range' => 'BDT 25L+', 'roi' => 'Projected 22%', 'image' => 'https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?auto=format&fit=crop&w=900&q=80', 'summary' => 'Commercial property concept for technology-enabled agro services and operations.'],
            ['title' => 'The Royal Valley', 'type' => 'Eco-Tourism', 'location' => 'Rajshahi', 'price_range' => 'BDT 12L - 35L', 'roi' => 'Projected 20%', 'image' => 'https://images.unsplash.com/photo-1500382017468-9049fed747ef?auto=format&fit=crop&w=900&q=80', 'summary' => 'A premium rural property portfolio anchored in recreation, landscape value, and agriculture.'],
        ] as $property) {
            Property::create($property);
        }

        foreach ([
            ['name' => 'Royal Ghee', 'category' => 'Dairy', 'price' => 980, 'badge' => 'Top Selling', 'image' => 'https://images.unsplash.com/photo-1587486913049-53fc88980cfc?auto=format&fit=crop&w=700&q=80'],
            ['name' => 'Mustard Oil', 'category' => 'Spices', 'price' => 420, 'badge' => 'Trending', 'image' => 'https://images.unsplash.com/photo-1474979266404-7eaacbcd87c5?auto=format&fit=crop&w=700&q=80'],
            ['name' => 'Fresh Vegetables Box', 'category' => 'Vegetables', 'price' => 650, 'badge' => 'New Arrival', 'image' => 'https://images.unsplash.com/photo-1542838132-92c53300491e?auto=format&fit=crop&w=700&q=80'],
            ['name' => 'Mango Export Pack', 'category' => 'Fruits', 'price' => 1450, 'badge' => 'Seasonal', 'image' => 'https://images.unsplash.com/photo-1553279768-865429fa0078?auto=format&fit=crop&w=700&q=80'],
            ['name' => 'Native Fish Pack', 'category' => 'Fish', 'price' => 1200, 'badge' => 'Fresh', 'image' => 'https://images.unsplash.com/photo-1519708227418-c8fd9a32b7a2?auto=format&fit=crop&w=700&q=80'],
            ['name' => 'Honey Export Jar', 'category' => 'Beverages', 'price' => 760, 'badge' => 'Premium', 'image' => 'https://images.unsplash.com/photo-1587049352851-8d4e89133924?auto=format&fit=crop&w=700&q=80'],
        ] as $product) {
            Product::create($product);
        }

        foreach ([
            ['title' => 'Farmer onboarding and field audit completed in Rangpur', 'type' => 'News', 'published_at' => '2026-05-20', 'image' => 'https://images.unsplash.com/photo-1625246333195-78d9c38ad449?auto=format&fit=crop&w=900&q=80', 'excerpt' => 'Smart Agro field teams completed new farmer verification, crop planning, and quality benchmarks for the upcoming production cycle.'],
            ['title' => 'Cold-chain and collection hubs improve farm produce sales', 'type' => 'News', 'published_at' => '2026-04-28', 'image' => 'https://images.unsplash.com/photo-1565300958219-b8a246755a01?auto=format&fit=crop&w=900&q=80', 'excerpt' => 'Better logistics reduce spoilage and help farmers reach buyers with fresher produce and stronger margins.'],
            ['title' => 'New collection hub launched for fresh produce trading', 'type' => 'News', 'published_at' => '2026-04-18', 'image' => 'https://images.unsplash.com/photo-1565300958219-b8a246755a01?auto=format&fit=crop&w=900&q=80', 'excerpt' => 'The new hub improves grading, storage, and buyer coordination for perishable crops.'],
            ['title' => 'How Mudarabah profit sharing works in agriculture', 'type' => 'Blog', 'published_at' => '2026-05-12', 'image' => 'https://images.unsplash.com/photo-1454165804606-c3d57bc86b40?auto=format&fit=crop&w=900&q=80', 'excerpt' => 'A practical explanation of transparent, halal profit-sharing for managed agro projects and investor reporting.'],
            ['title' => 'Agrotech Ecosystems: Aligning Technology, Finance and Food Security', 'type' => 'Blog', 'published_at' => '2026-05-02', 'image' => 'https://images.unsplash.com/photo-1560493676-04071c5f467b?auto=format&fit=crop&w=900&q=80', 'excerpt' => 'Why agriculture platforms need field operations, digital reporting, and disciplined capital planning.'],
            ['title' => 'Impact Investing in Agriculture: Building a Sustainable Food Future', 'type' => 'Blog', 'published_at' => '2026-04-22', 'image' => 'https://images.unsplash.com/photo-1464226184884-fa280b87c399?auto=format&fit=crop&w=900&q=80', 'excerpt' => 'A look at how patient capital can support farmers, improve supply chains, and create measurable returns.'],
        ] as $post) {
            Post::create($post + [
                'slug' => Str::slug($post['title']),
                'content' => 'Smart Agro publishes this update to help investors, farmers, and partners understand how agriculture projects are planned and operated. The story covers field coordination, capital discipline, reporting, and the practical work needed to connect production with stronger markets. Our goal is to make agriculture more transparent, more investable, and more resilient for every participant in the value chain.',
            ]);
        }

        foreach ([
            ['sort_order' => 1, 'question' => 'What is Smart Agro?', 'answer' => 'Smart Agro connects farmers, investors, products, and property-backed agro opportunities through managed projects and transparent reporting.'],
            ['sort_order' => 2, 'question' => 'How can I invest in a project?', 'answer' => 'Choose a live project, review duration, minimum investment, ROI, and status, then submit an investment request from the project card.'],
            ['sort_order' => 3, 'question' => 'Is the profit model halal?', 'answer' => 'The site presents a Mudarabah-style profit-sharing model where returns are distributed from project outcomes according to agreed terms.'],
            ['sort_order' => 4, 'question' => 'When do projects mature?', 'answer' => 'Each project has a separate start date, maturity date, and duration based on its crop, livestock, or trading cycle.'],
            ['sort_order' => 5, 'question' => 'How are profits distributed to investors?', 'answer' => 'Profits are distributed based on project performance, investor share, and the agreement terms communicated before investment.'],
        ] as $faq) {
            Faq::create($faq);
        }

        foreach ([
            ['name' => 'Aminul Haque', 'designation' => 'Agro Investor', 'avatar' => 'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?auto=format&fit=crop&w=300&q=80', 'quote' => 'The dashboard-style project data made it easier to compare investment time, ROI, and maturity before committing.'],
            ['name' => 'Nusrat Jahan', 'designation' => 'Supply Chain Partner', 'avatar' => 'https://images.unsplash.com/photo-1494790108377-be9c29b29330?auto=format&fit=crop&w=300&q=80', 'quote' => 'Smart Agro brings farmers and buyers into a more organized channel, which is exactly what perishable produce needs.'],
            ['name' => 'Mahmud Rahman', 'designation' => 'Field Coordinator', 'avatar' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=crop&w=300&q=80', 'quote' => 'The strongest part is the mix of field work, certification, and structured reporting for every project cycle.'],
        ] as $testimonial) {
            Testimonial::create($testimonial);
        }

        $investor = User::factory()->create([
            'name' => 'Demo Investor',
            'email' => 'investor@example.com',
            'role' => 'investor',
            'phone' => '017********',
            'address' => 'Dhaka, Bangladesh',
            'is_verified' => true,
            'password' => 'password',
        ]);

        User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'role' => 'admin',
            'phone' => '017********',
            'address' => 'Mohakhali, Dhaka',
            'is_verified' => true,
            'password' => 'password',
        ]);

        foreach (Project::where('is_live', true)->take(2)->get() as $project) {
            $amount = (float) $project->minimum_investment * 2;
            $roi = (float) filter_var($project->roi, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);

            Investment::create([
                'user_id' => $investor->id,
                'project_id' => $project->id,
                'amount' => $amount,
                'expected_return' => $amount + ($amount * ($roi / 100)),
                'invested_at' => now()->subDays(rand(4, 12)),
                'matured_at' => $project->mature_date,
                'status' => 'active',
                'note' => 'Seeded demo investment.',
            ]);
        }
    }
}
