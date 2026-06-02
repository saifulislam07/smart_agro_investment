@extends('layouts.app', ['title' => 'Contact | Smart Agro'])

@section('content')
    <header class="page-hero image-hero" style="--hero-image: url('https://images.unsplash.com/photo-1497366754035-f200968a6e72?auto=format&fit=crop&w=1800&q=80')">
        <div class="container">
            <div class="hero-copy animate-soft">
                <span class="eyebrow">Contact</span>
                <h1 class="fw-bold mt-2 mb-3">Talk to Smart Agro support.</h1>
                <p class="lead mb-0">Reach our team for project details, property information, product orders, and investor support.</p>
            </div>
        </div>
    </header>
    <main class="section">
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-5">
                    <div class="content-box h-100 animate-soft">
                        <h2 class="h4 fw-bold">Office</h2>
                        <p>Ambon Complex 99, Mohakhali C/A, Dhaka 1212</p>
                        <p><strong>Phone:</strong> 017********</p>
                        <p><strong>Email:</strong> info@smartagro.com</p>
                        <div class="map-box">Dhaka Office Map Placeholder</div>
                    </div>
                </div>
                <div class="col-lg-7">
                    <div class="content-box animate-soft">
                        <h2 class="h4 fw-bold mb-3">Send Message</h2>
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                @foreach ($errors->all() as $error)
                                    <div>{{ $error }}</div>
                                @endforeach
                            </div>
                        @endif
                        <form method="POST" action="{{ route('contact.store') }}">
                            @csrf
                            <div class="row g-3">
                                <div class="col-md-6"><input class="form-control form-control-lg" name="name" placeholder="Name" value="{{ old('name') }}" required></div>
                                <div class="col-md-6"><input class="form-control form-control-lg" name="email" type="email" placeholder="Email" value="{{ old('email') }}" required></div>
                                <div class="col-md-6"><input class="form-control form-control-lg" name="phone" placeholder="Phone" value="{{ old('phone') }}"></div>
                                <div class="col-md-6"><input class="form-control form-control-lg" name="subject" placeholder="Subject" value="{{ old('subject') }}" required></div>
                                <div class="col-12"><textarea class="form-control" name="message" rows="6" placeholder="Message" required>{{ old('message') }}</textarea></div>
                            </div>
                            <button class="btn btn-primary btn-lg mt-3" type="submit">Submit Message</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
