@extends('layouts.app', ['title' => 'About Us | Smart Agro'])

@section('content')
    <header class="page-hero image-hero" style="--hero-image: url('https://images.unsplash.com/photo-1500382017468-9049fed747ef?auto=format&fit=crop&w=1800&q=80')">
        <div class="container">
            <div class="hero-copy animate-soft">
                <span class="eyebrow">Who We Are</span>
                <h1 class="fw-bold mt-2 mb-3">A farmer-first ecosystem for agro investment.</h1>
                <p class="lead mb-0">Smart Agro transforms decades of field experience from ROSA into a structured platform for funding, production, trading, and rural property opportunities.</p>
            </div>
        </div>
    </header>
    <main class="section">
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-7">
                    <div class="content-box h-100 animate-soft">
                        <h2 class="h4 fw-bold">Our Story</h2>
                        <p>Smart Agro bridges resource and knowledge gaps in agriculture by connecting investors with managed projects and farmers with operational support.</p>
                        <p>ROSA, Rural Organisations for Social Affairs, has worked with rural communities since 1992. Smart Agro builds on that foundation to bring transparency, financial planning, and market access into the agriculture value chain.</p>
                        <h3 class="h5 fw-bold mt-4">Milestones</h3>
                        <div class="timeline">
                            <span><strong>1992</strong> ROSA begins rural development work.</span>
                            <span><strong>2003</strong> Smart Agro incorporated.</span>
                            <span><strong>2026</strong> Premium digital platform rebuilt on Laravel 12.</span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-5">
                    <div class="cert-box h-100 animate-soft">
                        <span class="eyebrow">Compliance</span>
                        <h2 class="h4 fw-bold mt-2">Trust Signals</h2>
                        <ul class="check-list mt-3">
                            <li><i class="bi bi-check-circle-fill"></i>RJSC Certificate of Incorporation No C-195903</li>
                            <li><i class="bi bi-check-circle-fill"></i>DCCI ECNGRO202507001532</li>
                            <li><i class="bi bi-check-circle-fill"></i>BIDA License No L-202508060017189-H</li>
                            <li><i class="bi bi-check-circle-fill"></i>DNCC Trade License No TRAD/DNCC/006823</li>
                            <li><i class="bi bi-check-circle-fill"></i>D&B D-U-N-S Number 77-411-5707</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
