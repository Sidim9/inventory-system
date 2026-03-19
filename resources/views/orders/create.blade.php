@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
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
            <div class="mb-3">
                <label class="form-label">Order nummer</label>
                <input type="text" name="order_number" class="form-control" value="{{ old('order_number') }}">
            </div>
            <div class="mb-3">
                <label class="form-label">Externe order ID</label>
                <input type="text" name="external_order_id" class="form-control" value="{{ old('external_order_id') }}">
            </div>
            <div class="mb-3">
                <label class="form-label">Marketplace</label>
                <select name="marketplace_id" class="form-select">
                    <option value="">-- Geen marketplace --</option>
                    @foreach ($marketplaces as $marketplace)
                        <option value="{{ $marketplace->id }}" {{ old('marketplace_id') == $marketplace->id ? 'selected' : '' }}>
                            {{ $marketplace->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label">Klant naam</label>
                <input type="text" name="customer_name" class="form-control" value="{{ old('customer_name') }}">
            </div>
            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" name="customer_email" class="form-control" value="{{ old('customer_email') }}">
            </div>
            <div class="mb-3">
                <label class="form-label">Status</label>
                <input type="text" name="status" class="form-control" value="{{ old('status', 'pending') }}">
            </div>
            <div class="mb-3">
                <label class="form-label">Sort order</label>
                <input type="number" name="sort_order" class="form-control" value="{{ old('sort_order', 0) }}">
            </div>
            <button type="submit" class="btn btn-primary">Opslaan</button>
            <a href="{{ route('orders.index') }}" class="btn btn-secondary">Annuleren</a>
        </form>
    </div>
</div>
@endsection