@extends('layouts.app', ['title' => 'Edit Investment | Smart Agro'])

@section('content')
    @php
        $project = $investment->project;
        $selectedMethod = old('payment_method', $investment->payment_method ?? '');
    @endphp

    <header class="page-hero compact">
        <div class="container">
            <span class="eyebrow">Edit Investment · {{ $project->title }}</span>
            <h1 class="fw-bold mt-2 mb-0">Update Payment Details</h1>
        </div>
    </header>

    <main class="section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-6">
                    <div class="content-box">

                        <div class="alert alert-info small mb-4">
                            <strong>Note:</strong> You can only edit while the investment is <em>Pending</em> approval.
                            Once approved by admin, changes are locked.
                        </div>

                        @if ($errors->any())
                            <div class="alert alert-danger">
                                @foreach ($errors->all() as $error)
                                    <div>{{ $error }}</div>
                                @endforeach
                            </div>
                        @endif

                        <form method="POST" action="{{ route('investments.update', $investment) }}">
                            @csrf
                            @method('PUT')

                            {{-- Project summary --}}
                            <div class="data-grid mb-4">
                                <span>Project<strong>{{ $project->title }}</strong></span>
                                <span>ROI<strong>{{ $project->roi }}</strong></span>
                                <span>Minimum<strong>BDT {{ number_format($project->minimum_investment, 2) }}</strong></span>
                                <span>Mature Date<strong>{{ $project->mature_date->format('d M Y') }}</strong></span>
                            </div>

                            {{-- Amount --}}
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Investment Amount (BDT)</label>
                                <input class="form-control form-control-lg" name="amount" type="number"
                                    min="{{ $project->minimum_investment }}" step="100"
                                    value="{{ old('amount', $investment->amount) }}" required>
                            </div>

                            {{-- Payment Method --}}
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Payment Method</label>
                                <select class="form-select" name="payment_method" id="paymentMethod" required>
                                    <option value="" disabled @selected(!$selectedMethod)>-- Select payment method --</option>
                                    <option value="bkash"  @selected($selectedMethod === 'bkash')>📱 bKash</option>
                                    <option value="nagad"  @selected($selectedMethod === 'nagad')>📱 Nagad</option>
                                    <option value="bank"   @selected($selectedMethod === 'bank')>🏦 Bank Deposit / Transfer</option>
                                </select>
                            </div>

                            {{-- bKash / Nagad --}}
                            <div id="mobileFields" class="payment-section" style="display:none;">
                                <div class="mb-3">
                                    <label class="form-label" id="mobileAccountLabel">bKash Number (Sender)</label>
                                    <input class="form-control" name="payment_account_number" id="mobileAccount"
                                        type="tel" placeholder="01XXXXXXXXX"
                                        value="{{ old('payment_account_number', $investment->payment_method !== 'bank' ? $investment->payment_account_number : '') }}">
                                    <div class="form-text">পেমেন্ট করা নম্বর লিখুন।</div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Transaction ID (TrxID)</label>
                                    <input class="form-control" name="payment_reference" id="mobileRef"
                                        type="text" placeholder="e.g. ABC1234567"
                                        value="{{ old('payment_reference', $investment->payment_method !== 'bank' ? $investment->payment_reference : '') }}">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Payment Date</label>
                                    <input class="form-control" name="payment_date" id="mobileDate"
                                        type="date"
                                        value="{{ old('payment_date', $investment->payment_method !== 'bank' ? $investment->payment_date?->format('Y-m-d') : '') }}">
                                </div>
                            </div>

                            {{-- Bank --}}
                            <div id="bankFields" class="payment-section" style="display:none;">
                                <div class="mb-3">
                                    <label class="form-label">Bank Name</label>
                                    <input class="form-control" name="payment_bank_name" type="text"
                                        placeholder="e.g. Dutch Bangla Bank"
                                        value="{{ old('payment_bank_name', $investment->payment_bank_name) }}">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Account Number (Sender)</label>
                                    <input class="form-control" name="payment_account_number" id="bankAccount"
                                        type="text" placeholder="Your bank account number"
                                        value="{{ old('payment_account_number', $investment->payment_method === 'bank' ? $investment->payment_account_number : '') }}">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Deposit Slip / Reference</label>
                                    <input class="form-control" name="payment_reference" id="bankRef"
                                        type="text" placeholder="Deposit slip or cheque number"
                                        value="{{ old('payment_reference', $investment->payment_method === 'bank' ? $investment->payment_reference : '') }}">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Deposit Date</label>
                                    <input class="form-control" name="payment_date" id="bankDate"
                                        type="date"
                                        value="{{ old('payment_date', $investment->payment_method === 'bank' ? $investment->payment_date?->format('Y-m-d') : '') }}">
                                </div>
                            </div>

                            {{-- Note --}}
                            <div class="mb-3">
                                <label class="form-label">Investor Note <span class="text-muted">(Optional)</span></label>
                                <textarea class="form-control" name="note" rows="2"
                                    placeholder="Any additional info for the admin team">{{ old('note', $investment->note) }}</textarea>
                            </div>

                            <div class="d-flex gap-3 mt-4">
                                <button class="btn btn-primary" type="submit">Save Changes</button>
                                <a class="btn btn-outline-secondary" href="{{ route('dashboard') }}">Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>
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

            mobileFields.style.display = 'none';
            bankFields.style.display   = 'none';
            document.querySelectorAll('.payment-section input').forEach(el => {
                el.disabled = true;
                el.removeAttribute('required');
            });

            if (method === 'bkash' || method === 'nagad') {
                mobileFields.style.display = 'block';
                if (mobileLabel) mobileLabel.textContent = method === 'bkash' ? 'bKash Number (Sender)' : 'Nagad Number (Sender)';
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

        document.querySelectorAll('.payment-section input').forEach(el => el.disabled = true);
        methodSelect.addEventListener('change', function () { toggleFields(this.value); });
        if (methodSelect.value) toggleFields(methodSelect.value);
    })();
</script>
@endpush
