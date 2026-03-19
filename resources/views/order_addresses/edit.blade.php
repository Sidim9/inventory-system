@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-7">
        <h1 class="mb-4">Orderadres bewerken</h1>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('order_addresses.update', $orderAddress->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label class="form-label">Order</label>
                <select name="order_id" class="form-select">
                    <option value="">-- Selecteer order --</option>
                    @foreach ($orders as $order)
                        <option value="{{ $order->id }}" {{ old('order_id', $orderAddress->order_id) == $order->id ? 'selected' : '' }}>{{ $order->order_number }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label">Type</label>
                <input type="text" name="type" class="form-control" value="{{ old('type', $orderAddress->type) }}">
            </div>
            <div class="row">
                <div class="col mb-3">
                    <label class="form-label">Voornaam</label>
                    <input type="text" name="first_name" class="form-control" value="{{ old('first_name', $orderAddress->first_name) }}">
                </div>
                <div class="col mb-3">
                    <label class="form-label">Achternaam</label>
                    <input type="text" name="last_name" class="form-control" value="{{ old('last_name', $orderAddress->last_name) }}">
                </div>
            </div>
            <div class="mb-3">
                <label class="form-label">Bedrijf</label>
                <input type="text" name="company" class="form-control" value="{{ old('company', $orderAddress->company) }}">
            </div>
            <div class="row">
                <div class="col-8 mb-3">
                    <label class="form-label">Straat</label>
                    <input type="text" name="street" class="form-control" value="{{ old('street', $orderAddress->street) }}">
                </div>
                <div class="col mb-3">
                    <label class="form-label">Huisnummer</label>
                    <input type="text" name="house_number" class="form-control" value="{{ old('house_number', $orderAddress->house_number) }}">
                </div>
                <div class="col mb-3">
                    <label class="form-label">Toevoeging</label>
                    <input type="text" name="house_number_addition" class="form-control" value="{{ old('house_number_addition', $orderAddress->house_number_addition) }}">
                </div>
            </div>
            <div class="row">
                <div class="col mb-3">
                    <label class="form-label">Postcode</label>
                    <input type="text" name="postal_code" class="form-control" value="{{ old('postal_code', $orderAddress->postal_code) }}">
                </div>
                <div class="col mb-3">
                    <label class="form-label">Stad</label>
                    <input type="text" name="city" class="form-control" value="{{ old('city', $orderAddress->city) }}">
                </div>
            </div>
            <div class="row">
                <div class="col mb-3">
                    <label class="form-label">Provincie/staat</label>
                    <input type="text" name="state" class="form-control" value="{{ old('state', $orderAddress->state) }}">
                </div>
                <div class="col mb-3">
                    <label class="form-label">Land</label>
                    <input type="text" name="country" class="form-control" value="{{ old('country', $orderAddress->country) }}">
                </div>
            </div>
            <div class="mb-3">
                <label class="form-label">Telefoon</label>
                <input type="text" name="phone" class="form-control" value="{{ old('phone', $orderAddress->phone) }}">
            </div>
            <button type="submit" class="btn btn-primary">Updaten</button>
            <a href="{{ route('order_addresses.index') }}" class="btn btn-secondary">Annuleren</a>
        </form>
    </div>
</div>
@endsection
