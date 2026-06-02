@extends('layouts.app', ['title' => 'Register | Smart Agro'])

@section('content')
    <main class="auth-wrap">
        <div class="auth-card wide">
            <span class="eyebrow">Create Account</span>
            <h1 class="h3 fw-bold mt-2 mb-4">Start your investor profile</h1>
            @if ($errors->any())
                <div class="alert alert-danger">
                    @foreach ($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            @endif
            <form method="POST" action="{{ route('register.store') }}">
                @csrf
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Name</label>
                        <input class="form-control form-control-lg" name="name" value="{{ old('name') }}" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Email</label>
                        <input class="form-control form-control-lg" name="email" type="email" value="{{ old('email') }}" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Phone</label>
                        <input class="form-control form-control-lg" name="phone" value="{{ old('phone') }}">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Address</label>
                        <input class="form-control form-control-lg" name="address" value="{{ old('address') }}">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Password</label>
                        <input class="form-control form-control-lg" name="password" type="password" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Confirm Password</label>
                        <input class="form-control form-control-lg" name="password_confirmation" type="password" required>
                    </div>
                </div>
                <button class="btn btn-primary btn-lg w-100 mt-4" type="submit">Create Account</button>
            </form>
            <p class="text-center mt-4 mb-0">Already registered? <a href="{{ route('login') }}">Login</a></p>
        </div>
    </main>
@endsection

