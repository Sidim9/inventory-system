@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <h1 class="mb-4">Order bewerken</h1>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('orders.update', $order->id) }}" method="POST">
            @csrf
            @method('PUT')

            <h5 class="mb-3 border-bottom pb-2">Ordergegevens</h5>
            <div class="row g-3 mb-4">
                <div class="col-md-6">
                    <label class="form-label">Ordernummer <span class="text-danger">*</span></label>
                    <input type="text" name="order_number" class="form-control" value="{{ old('order_number', $order->order_number) }}" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Bron</label>
                    <input type="text" name="source" class="form-control" value="{{ old('source', $order->source) }}" placeholder="bijv. Amazon, Webshop, Handmatig">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Status <span class="text-danger">*</span></label>
                    <select name="status" class="form-select" required>
                        @foreach(\App\Enums\OrderStatus::cases() as $status)
                            <option value="{{ $status->value }}" {{ old('status', $order->status->value) === $status->value ? 'selected' : '' }}>{{ $status->label() }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Besteldatum</label>
                    <input type="datetime-local" name="ordered_at" class="form-control"
                        value="{{ old('ordered_at', $order->ordered_at?->format('Y-m-d\TH:i')) }}">
                </div>
                <div class="col-12">
                    <label class="form-label">Notities</label>
                    <textarea name="notes" class="form-control" rows="2">{{ old('notes', $order->notes) }}</textarea>
                </div>
            </div>

            <h5 class="mb-3 border-bottom pb-2">Klantgegevens</h5>
            <div class="row g-3 mb-4">
                <div class="col-md-6">
                    <label class="form-label">Klantnaam</label>
                    <input type="text" name="customer_name" class="form-control" value="{{ old('customer_name', $order->customer_name) }}">
                </div>
                <div class="col-md-6">
                    <label class="form-label">E-mailadres</label>
                    <input type="email" name="customer_email" class="form-control" value="{{ old('customer_email', $order->customer_email) }}">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Bedrijf</label>
                    <input type="text" name="company_name" class="form-control" value="{{ old('company_name', $order->company_name) }}">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Telefoonnummer</label>
                    <input type="text" name="phone" class="form-control" value="{{ old('phone', $order->phone) }}">
                </div>
            </div>

            <h5 class="mb-3 border-bottom pb-2">Bezorgadres</h5>
            <div class="row g-3 mb-4">
                <div class="col-md-6">
                    <label class="form-label">Straat</label>
                    <input type="text" name="street" class="form-control" value="{{ old('street', $order->street) }}">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Huisnummer</label>
                    <input type="text" name="house_number" class="form-control" value="{{ old('house_number', $order->house_number) }}">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Toevoeging</label>
                    <input type="text" name="house_number_addition" class="form-control" value="{{ old('house_number_addition', $order->house_number_addition) }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Postcode</label>
                    <input type="text" name="postal_code" class="form-control" value="{{ old('postal_code', $order->postal_code) }}">
                </div>
                <div class="col-md-5">
                    <label class="form-label">Stad</label>
                    <input type="text" name="city" class="form-control" value="{{ old('city', $order->city) }}">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Land</label>
                    <input type="text" name="country" class="form-control" value="{{ old('country', $order->country) }}">
                </div>
            </div>

            <button type="submit" class="btn btn-primary">Updaten</button>
            <a href="{{ route('orders.show', $order->id) }}" class="btn btn-secondary">Annuleren</a>
        </form>
    </div>
</div>
@endsection