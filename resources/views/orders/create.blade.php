@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <h1 class="mb-4">Nieuwe order</h1>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('orders.store') }}" method="POST">
            @csrf

            <h5 class="mb-3 border-bottom pb-2">Ordergegevens</h5>
            <div class="row g-3 mb-4">
                <div class="col-md-6">
                    <label class="form-label">Ordernummer</label>
                    <input type="text" name="order_number" class="form-control bg-light" value="{{ old('order_number', $suggestedOrderNumber) }}" readonly>
                    <div class="form-text">Automatisch gegenereerd</div>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Bron</label>
                    <input type="text" name="source" class="form-control" value="{{ old('source') }}" placeholder="bijv. Amazon, Webshop, Handmatig">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Status <span class="text-danger">*</span></label>
                    <select name="status" class="form-select" required>
                        @foreach(['pending','processing','shipped','delivered','cancelled'] as $s)
                            <option value="{{ $s }}" {{ old('status', 'pending') === $s ? 'selected' : '' }}>{{ ucfirst($s) }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Besteldatum</label>
                    <input type="datetime-local" name="ordered_at" class="form-control" value="{{ old('ordered_at', now()->format('Y-m-d\TH:i')) }}">
                </div>
                <div class="col-12">
                    <label class="form-label">Notities</label>
                    <textarea name="notes" class="form-control" rows="2">{{ old('notes') }}</textarea>
                </div>
            </div>

            <h5 class="mb-3 border-bottom pb-2">Klantgegevens</h5>
            <div class="row g-3 mb-4">
                <div class="col-md-6">
                    <label class="form-label">Klantnaam</label>
                    <input type="text" name="customer_name" class="form-control" value="{{ old('customer_name') }}">
                </div>
                <div class="col-md-6">
                    <label class="form-label">E-mailadres</label>
                    <input type="email" name="customer_email" class="form-control" value="{{ old('customer_email') }}">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Telefoonnummer</label>
                    <input type="text" name="phone" class="form-control" value="{{ old('phone') }}">
                </div>
            </div>

            <h5 class="mb-3 border-bottom pb-2">Bezorgadres</h5>
            <div class="row g-3 mb-4">
                <div class="col-md-6">
                    <label class="form-label">Straat</label>
                    <input type="text" name="street" class="form-control" value="{{ old('street') }}">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Huisnummer</label>
                    <input type="text" name="house_number" class="form-control" value="{{ old('house_number') }}">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Toevoeging</label>
                    <input type="text" name="house_number_addition" class="form-control" value="{{ old('house_number_addition') }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Postcode</label>
                    <input type="text" name="postal_code" class="form-control" value="{{ old('postal_code') }}">
                </div>
                <div class="col-md-5">
                    <label class="form-label">Stad</label>
                    <input type="text" name="city" class="form-control" value="{{ old('city') }}">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Land</label>
                    <input type="text" name="country" class="form-control" value="{{ old('country', 'NL') }}">
                </div>
            </div>

            <button type="submit" class="btn btn-primary">Order aanmaken</button>
            <a href="{{ route('orders.index') }}" class="btn btn-secondary">Annuleren</a>
        </form>
    </div>
</div>
@endsection