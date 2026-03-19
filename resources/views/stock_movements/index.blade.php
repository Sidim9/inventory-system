@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h1>Voorraadbewegingen</h1>
    <a href="{{ route('stock_movements.create') }}" class="btn btn-primary">Nieuwe beweging</a>
</div>

@forelse ($stockMovements as $movement)
    <div class="card mb-2 border-0 shadow-sm">
        <div class="card-body d-flex justify-content-between align-items-center">
            <span>
                <strong>{{ $movement->product->name ?? 'Onbekend' }}</strong> &mdash;
                <span class="badge bg-secondary">{{ $movement->type }}</span> &mdash;
                Wijziging: {{ $movement->quantity_change > 0 ? '+' : '' }}{{ $movement->quantity_change }} &mdash;
                {{ $movement->stock_before }} &rarr; {{ $movement->stock_after }}
                @if ($movement->order)
                    &mdash; Order: {{ $movement->order->order_number }}
                @endif
            </span>
            <div class="d-flex gap-2">
                <a href="{{ route('stock_movements.show', $movement->id) }}" class="btn btn-sm btn-outline-secondary">Bekijk</a>
                <a href="{{ route('stock_movements.edit', $movement->id) }}" class="btn btn-sm btn-outline-primary">Bewerk</a>
                <form action="{{ route('stock_movements.destroy', $movement->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Weet je het zeker?')">Verwijder</button>
                </form>
            </div>
        </div>
    </div>
@empty
    <p class="text-muted">Geen voorraadbewegingen gevonden.</p>
@endforelse
@endsection
