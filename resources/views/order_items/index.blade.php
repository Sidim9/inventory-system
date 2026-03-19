@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h1>Orderregels</h1>
    <a href="{{ route('order_items.create') }}" class="btn btn-primary">Nieuwe orderregel</a>
</div>

@forelse ($orderItems as $item)
    <div class="card mb-2 border-0 shadow-sm">
        <div class="card-body d-flex justify-content-between align-items-center">
            <span>
                Order: <strong>{{ $item->order->order_number ?? 'Onbekend' }}</strong> &mdash;
                {{ $item->product_name }} ({{ $item->sku }}) &mdash;
                Aantal: {{ $item->quantity }}
            </span>
            <div class="d-flex gap-2">
                <a href="{{ route('order_items.show', $item->id) }}" class="btn btn-sm btn-outline-secondary">Bekijk</a>
                <a href="{{ route('order_items.edit', $item->id) }}" class="btn btn-sm btn-outline-primary">Bewerk</a>
                <form action="{{ route('order_items.destroy', $item->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Weet je het zeker?')">Verwijder</button>
                </form>
            </div>
        </div>
    </div>
@empty
    <p class="text-muted">Geen orderregels gevonden.</p>
@endforelse
@endsection
