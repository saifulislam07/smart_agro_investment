@extends('layouts.app', ['title' => $project->title . ' | Smart Agro'])

@section('content')
    @php
        $progress = min(100, ((float) $project->raised / (float) $project->goal) * 100);
        $waiting = max((float) $project->goal - (float) $project->raised, 0);
        $selectedMethod = old('payment_method', '');
    @endphp

    <header class="project-detail-hero">
        <div class="container">
            <div class="row g-5 align-items-center">
                <div class="col-lg-6">
                    <span class="eyebrow">{{ $project->category }} · {{ $project->status }}</span>
                    <h1 class="fw-bold mt-2 mb-3">{{ $project->title }}</h1>
                    <p class="lead">{{ $project->summary }}</p>
                    <div class="progress my-4">
                        <div class="progress-bar" style="width: {{ $progress }}%"></div>
                    </div>
                    <div class="hero-metrics">
                        <span>Raised<strong>BDT {{ number_format($project->raised, 2) }}</strong></span>
                        <span>Goal<strong>BDT {{ number_format($project->goal, 2) }}</strong></span>
                        <span>ROI<strong>{{ $project->roi }}</strong></span>
                    </div>
                </div>
                <div class="col-lg-6">
                    <img class="detail-image" src="{{ $project->image }}" alt="{{ $project->title }}">
                </div>
            </div>
        </div>
    </header>

    <main class="section">
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-8">
                    <div class="content-box mb-4">
                        <h2 class="h4 fw-bold">Project Narrative</h2>
                        <p>{{ $project->description }}</p>
                        <h3 class="h5 fw-bold mt-4">Market Opportunity</h3>
                        <p>{{ $project->market_opportunity }}</p>
                        <h3 class="h5 fw-bold mt-4">Risk Factors</h3>
                        <p>{{ $project->risk_factors }}</p>
                    </div>

                    <div class="content-box">
                        <h2 class="h4 fw-bold mb-3">Project Gallery</h2>
                        <div class="row g-3">
                            @foreach ($project->gallery ?? [] as $image)
                                <div class="col-sm-4">
                                    <img class="gallery-img" src="{{ $image }}"
                                        alt="{{ $project->title }} gallery image">
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <aside class="col-lg-4">
                    <div class="invest-box">
                        <h2 class="h4 fw-bold">Invest Now</h2>
                        <div class="data-grid my-3">
                            <span>Business type<strong>{{ $project->business_type }}</strong></span>
                            <span>Duration<strong>{{ $project->duration }}</strong></span>
                            <span>Start Date<strong>{{ $project->start_date->format('d-m-Y') }}</strong></span>
                            <span>Mature Date<strong>{{ $project->mature_date->format('d-m-Y') }}</strong></span>
                            <span>Minimum<strong>BDT {{ number_format($project->minimum_investment, 2) }}</strong></span>
                            <span>Waiting<strong>BDT {{ number_format($waiting, 2) }}</strong></span>
                        </div>

                        @if ($errors->any())
                            <div class="alert alert-danger">
                                @foreach ($errors->all() as $error)
                                    <div>{{ $error }}</div>
                                @endforeach
                            </div>
                        @endif

                        @auth
                            <form method="POST" action="{{ route('investments.store', $project) }}" id="investForm">
                                @csrf
                                <div class="alert alert-warning small mb-3">
                                    <strong>Note:</strong> Investment is submitted as <em>Pending</em>. It will be
                                    confirmed only after admin verification of your payment.
                                </div>

                                {{-- Amount --}}
                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Investment Amount (BDT)</label>
                                    <input class="form-control form-control-lg" name="amount" type="number"
                                        min="{{ $project->minimum_investment }}" step="100"
                                        value="{{ old('amount', $project->minimum_investment) }}" required>
                                </div>

                                {{-- Payment Method --}}
                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Payment Method</label>
                                    <select class="form-select" name="payment_method" id="paymentMethod" required>
                                        <option value="" disabled @selected(!$selectedMethod)>-- Select payment method --</option>
                                        <option value="bkash" @selected($selectedMethod === 'bkash')>
                                            📱 bKash
                                        </option>
                                        <option value="nagad" @selected($selectedMethod === 'nagad')>
                                            📱 Nagad
                                        </option>
                                        <option value="bank" @selected($selectedMethod === 'bank')>
                                            🏦 Bank Deposit / Transfer
                                        </option>
                                    </select>
                                </div>

                                {{-- bKash / Nagad fields --}}
                                <div id="mobileFields" class="payment-section" style="display:none;">
                                    <div class="mb-3">
                                        <label class="form-label" id="mobileAccountLabel">bKash Number (Sender)</label>
                                        <input class="form-control" name="payment_account_number" id="mobileAccount"
                                            type="tel" placeholder="01XXXXXXXXX"
                                            value="{{ old('payment_account_number') }}">
                                        <div class="form-text">আপনার বিকাশ / নগদ নম্বর লিখুন যেটি থেকে পেমেন্ট করেছেন।</div>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Transaction ID (TrxID)</label>
                                        <input class="form-control" name="payment_reference" id="mobileRef"
                                            type="text" placeholder="e.g. ABC1234567"
                                            value="{{ old('payment_reference') }}">
                                        <div class="form-text">পেমেন্টের পর প্রাপ্ত Transaction ID লিখুন।</div>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Payment Date</label>
                                        <input class="form-control" name="payment_date" id="mobileDate"
                                            type="date" value="{{ old('payment_date') }}">
                                    </div>
                                </div>

                                {{-- Bank fields --}}
                                <div id="bankFields" class="payment-section" style="display:none;">
                                    <div class="mb-3">
                                        <label class="form-label">Bank Name</label>
                                        <input class="form-control" name="payment_bank_name" type="text"
                                            placeholder="e.g. Dutch Bangla Bank, Islami Bank"
                                            value="{{ old('payment_bank_name') }}">
                                        <div class="form-text">যে ব্যাংক থেকে জমা দিয়েছেন তার নাম লিখুন।</div>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Account Number (Sender)</label>
                                        <input class="form-control" name="payment_account_number" id="bankAccount"
                                            type="text" placeholder="Your bank account number"
                                            value="{{ old('payment_account_number') }}">
                                        <div class="form-text">আপনার ব্যাংক অ্যাকাউন্ট নম্বর লিখুন।</div>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Deposit Slip / Reference Number</label>
                                        <input class="form-control" name="payment_reference" id="bankRef"
                                            type="text" placeholder="Deposit slip or cheque number"
                                            value="{{ old('payment_reference') }}">
                                        <div class="form-text">ডিপোজিট স্লিপ বা ট্রান্সফার রেফারেন্স নম্বর লিখুন।</div>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Deposit Date</label>
                                        <input class="form-control" name="payment_date" id="bankDate"
                                            type="date" value="{{ old('payment_date') }}">
                                    </div>
                                </div>

                                {{-- Hidden fallback for payment_account_number when no method selected --}}

                                {{-- Investor Note --}}
                                <div class="mb-3">
                                    <label class="form-label">Investor Note <span class="text-muted">(Optional)</span></label>
                                    <textarea class="form-control" name="note" rows="2"
                                        placeholder="Any additional info for the admin team">{{ old('note') }}</textarea>
                                </div>

                                <button class="btn btn-primary w-100 mt-2" type="submit" @disabled(!$project->is_live)>
                                    Submit Investment
                                </button>

                                @unless($project->is_live)
                                    <p class="text-danger small mt-2 text-center">This project is not open for investment.</p>
                                @endunless
                            </form>
                        @else
                            <a class="btn btn-primary w-100" href="{{ route('login') }}">Login to Invest</a>
                            <a class="btn btn-outline-dark w-100 mt-2" href="{{ route('register') }}">Create Investor
                                Account</a>
                        @endauth
                    </div>
                </aside>
            </div>
        </div>
    </main>
@endsection

@push('scripts')
<script>
    (function () {
        const methodSelect = document.getElementById('paymentMethod');
        if (!methodSelect) return;

        function toggleFields(method) {
            const mobileFields = document.getElementById('mobileFields');
            const bankFields   = document.getElementById('bankFields');
            const mobileLabel  = document.getElementById('mobileAccountLabel');

            // Disable + hide everything first
            mobileFields.style.display = 'none';
            bankFields.style.display   = 'none';
            document.querySelectorAll('.payment-section input').forEach(el => {
                el.disabled = true;
                el.removeAttribute('required');
            });

            if (method === 'bkash' || method === 'nagad') {
                mobileFields.style.display = 'block';
                if (mobileLabel) {
                    mobileLabel.textContent = method === 'bkash'
                        ? 'bKash Number (Sender)'
                        : 'Nagad Number (Sender)';
                }
                mobileFields.querySelectorAll('input').forEach(el => el.disabled = false);
                document.getElementById('mobileAccount').setAttribute('required', 'required');
                document.getElementById('mobileDate').setAttribute('required', 'required');

            } else if (method === 'bank') {
                bankFields.style.display = 'block';
                bankFields.querySelectorAll('input').forEach(el => el.disabled = false);
                document.getElementById('bankAccount').setAttribute('required', 'required');
                document.getElementById('bankDate').setAttribute('required', 'required');
            }
        }

        // Disable all payment sub-inputs on initial load
        document.querySelectorAll('.payment-section input').forEach(el => el.disabled = true);

        methodSelect.addEventListener('change', function () {
            toggleFields(this.value);
        });

        // Re-apply on page load (after a validation failure, old() restores the selection)
        if (methodSelect.value) {
            toggleFields(methodSelect.value);
        }
    })();
</script>
@endpush
