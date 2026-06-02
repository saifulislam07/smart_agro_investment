<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'Smart Agro' }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=outfit:400,500,600,700,800|playfair-display:700,800" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <div class="topbar py-2 d-none d-lg-block">
        <div class="container d-flex align-items-center gap-4 small">
            <div class="d-flex gap-4">
                <span><i class="bi bi-envelope me-2"></i>info@growupagro.tech</span>
                <span><i class="bi bi-telephone me-2"></i>+8801713269591</span>
            </div>
            <div class="top-marquee">
                <div class="top-marquee-track">
                    <span>Invest in agriculture with managed projects and verified reporting.</span>
                    <span>Smart Agro connects farmers, investors, products, and agro-backed opportunities.</span>
                    <span>Explore live projects, properties, products, NGO activities, news, and blogs.</span>
                </div>
            </div>
        </div>
    </div>

    <nav class="navbar navbar-expand-lg sticky-top">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center gap-2 fw-bold" href="{{ route('home') }}">
                <span class="brand-mark"><span>S</span></span>
                <span>Smart Agro</span>
            </a>
            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav" aria-controls="mainNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="mainNav">
                <ul class="navbar-nav mx-auto mb-2 mb-lg-0">
                    <li class="nav-item"><a class="nav-link" href="{{ route('home') }}">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('about') }}">About Us</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('projects.index') }}">Smart Agro Projects</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('properties.index') }}">Properties</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('products.index') }}">Products</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('ngo.activities') }}">NGO</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('news') }}">News</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('blogs') }}">Blog</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('contact') }}">Contact</a></li>
                </ul>
                <div class="d-flex gap-2">
                    @auth
                        <a href="{{ route('dashboard') }}" class="btn btn-outline-dark btn-sm">Dashboard</a>
                        @if (auth()->user()->role === 'admin')
                            <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-dark btn-sm">Admin</a>
                        @endif
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button class="btn btn-primary btn-sm" type="submit">Logout</button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="btn btn-outline-dark btn-sm">Login</a>
                        <a href="{{ route('register') }}" class="btn btn-primary btn-sm">Register</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    @if (session('status'))
        <div class="container mt-4">
            <div class="alert alert-success mb-0">{{ session('status') }}</div>
        </div>
    @endif

    @yield('content')

    <footer class="footer" id="contact">
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-4">
                    <a class="navbar-brand d-flex align-items-center gap-2 fw-bold mb-3" href="{{ route('home') }}">
                        <span class="brand-mark"><span>S</span></span>
                        <span>Smart Agro</span>
                    </a>
                    <p>Invest in agriculture through managed projects, ethical field operations, verified products, and farmer-centered execution.</p>
                </div>
                <div class="col-6 col-lg-2">
                    <h3 class="h6">Quick Links</h3>
                    <a href="{{ route('about') }}">Learn About Us</a>
                    <a href="{{ route('projects.index') }}">View Recent Projects</a>
                    <a href="{{ route('properties.index') }}">Properties</a>
                    <a href="{{ route('products.index') }}">Product</a>
                    <a href="{{ route('terms') }}">Terms & Conditions</a>
                </div>
                <div class="col-6 col-lg-3">
                    <h3 class="h6">Get In Touch</h3>
                    <span>Ambon Complex 99, Mohakhali C/A, Dhaka</span>
                    <span>+8801713269591</span>
                    <span>09611677833</span>
                    <span>info@growupagro.tech</span>
                </div>
                <div class="col-lg-3">
                    <h3 class="h6">Legal</h3>
                    <a href="{{ route('refund') }}">Refund Policy</a>
                    <a href="{{ route('delivery') }}">Delivery Policy</a>
                    <a href="{{ route('terms') }}">Terms & Conditions</a>
                    <a href="{{ route('privacy') }}">Privacy Policy</a>
                    <a href="{{ route('risk') }}">Risk Disclosure</a>
                </div>
            </div>
            <div class="footer-bottom">
                <span>© 2026 Smart Agro. All rights reserved.</span>
                <span><a href="{{ route('refund') }}">Refund Policy</a> · <a href="{{ route('delivery') }}">Delivery Policy</a> · <a href="{{ route('terms') }}">Terms & Conditions</a> · <a href="{{ route('privacy') }}">Privacy Policy</a></span>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

