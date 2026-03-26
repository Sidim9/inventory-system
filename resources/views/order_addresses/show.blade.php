@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <h1 class="mb-4">Orderadres</h1>
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <dl class="row mb-0">
                    <dt class="col-sm-5">Order</dt><dd class="col-sm-7">{{ $orderAddress->order->order_number ?? 'Onbekend' }}</dd>
                    <dt class="col-sm-5">Type</dt><dd class="col-sm-7"><span class="badge bg-secondary">{{ $orderAddress->type }}</span></dd>
                    <dt class="col-sm-5">Naam</dt><dd class="col-sm-7">{{ $orderAddress->first_name }} {{ $orderAddress->last_name }}</dd>
                    <dt class="col-sm-5">Bedrijf</dt><dd class="col-sm-7">{{ $orderAddress->company ?? '-' }}</dd>
                    <dt class="col-sm-5">Adres</dt><dd class="col-sm-7">{{ $orderAddress->street }} {{ $orderAddress->house_number }}{{ $orderAddress->house_number_addition }}</dd>
                    <dt class="col-sm-5">Postcode</dt><dd class="col-sm-7">{{ $orderAddress->postal_code }}</dd>
                    <dt class="col-sm-5">Stad</dt><dd class="col-sm-7">{{ $orderAddress->city }}</dd>
                    <dt class="col-sm-5">Provincie/staat</dt><dd class="col-sm-7">{{ $orderAddress->state ?? '-' }}</dd>
                    <dt class="col-sm-5">Land</dt><dd class="col-sm-7">{{ $orderAddress->country }}</dd>
                    <dt class="col-sm-5">Telefoon</dt><dd class="col-sm-7">{{ $orderAddress->phone ?? '-' }}</dd>
                    <dt class="col-sm-5">Aangemaakt op</dt><dd class="col-sm-7">{{ $orderAddress->created_at->format('d-m-Y H:i') }}</dd>
                </dl>
            </div>
        </div>
        <div class="mt-3 d-flex gap-2">
            <a href="{{ route('order_addresses.edit', $orderAddress->id) }}" class="btn btn-primary">Bewerk</a>
            <a href="{{ route('order_addresses.index') }}" class="btn btn-secondary">Terug</a>
        </div>
    </div>
</div>
@endsection
