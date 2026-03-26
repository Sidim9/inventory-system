@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h1>Orderadressen</h1>
    <a href="{{ route('order_addresses.create') }}" class="btn btn-primary">Nieuw adres</a>
</div>

@forelse ($orderAddresses as $address)
    <div class="card mb-2 border-0 shadow-sm">
        <div class="card-body d-flex justify-content-between align-items-center">
            <span>
                Order: <strong>{{ $address->order->order_number ?? 'Onbekend' }}</strong> &mdash;
                <span class="badge bg-secondary">{{ $address->type }}</span> &mdash;
                {{ $address->first_name }} {{ $address->last_name }},
                {{ $address->street }} {{ $address->house_number }}, {{ $address->city }} {{ $address->country }}
            </span>
            <div class="d-flex gap-2">
                <a href="{{ route('order_addresses.show', $address->id) }}" class="btn btn-sm btn-outline-secondary">Bekijk</a>
                <a href="{{ route('order_addresses.edit', $address->id) }}" class="btn btn-sm btn-outline-primary">Bewerk</a>
                <form action="{{ route('order_addresses.destroy', $address->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Weet je het zeker?')">Verwijder</button>
                </form>
            </div>
        </div>
    </div>
@empty
    <p class="text-muted">Geen orderadressen gevonden.</p>
@endforelse
@endsection
