@extends('layouts.app', ['title' => 'Login | GrowUp Agrotech'])

@section('content')
    <main class="auth-wrap">
        <div class="auth-card">
            <span class="eyebrow">Investor Access</span>
            <h1 class="h3 fw-bold mt-2 mb-4">Login to your account</h1>
            @if ($errors->any())
                <div class="alert alert-danger">
                    @foreach ($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            @endif
            <form method="POST" action="{{ route('login.store') }}">
                @csrf
                <label class="form-label">Email</label>
                <input class="form-control form-control-lg mb-3" name="email" type="email" value="{{ old('email') }}" required autofocus>
                <label class="form-label">Password</label>
                <input class="form-control form-control-lg mb-3" name="password" type="password" required>
                <div class="form-check mb-4">
                    <input class="form-check-input" id="remember" name="remember" type="checkbox" value="1">
                    <label class="form-check-label" for="remember">Remember me</label>
                </div>
                <button class="btn btn-primary btn-lg w-100" type="submit">Login</button>
            </form>
            <p class="text-center mt-4 mb-0">New investor? <a href="{{ route('register') }}">Create an account</a></p>
        </div>
    </main>
@endsection
