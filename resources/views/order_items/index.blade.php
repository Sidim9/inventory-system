@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h1>Orderregels</h1>
    <a href="{{ route('order_items.create') }}" class="btn btn-primary">Nieuwe orderregel</a>
</div>

<div class="table-responsive">
    <table class="table table-hover bg-white shadow-sm rounded">
        <thead class="table-light">
            <tr>
                <th>Order</th>
                <th>EAN</th>
                <th>SKU</th>
                <th>Productnaam</th>
                <th class="text-center">Aantal</th>
                <th class="text-end">Stukprijs</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @forelse ($orderItems as $item)
            <tr>
                <td><a href="{{ route('orders.show', $item->order_id) }}">{{ $item->order->order_number ?? '—' }}</a></td>
                <td>{{ $item->ean ?: '-' }}</td>
                <td><code>{{ $item->sku ?: '-' }}</code></td>
                <td>{{ $item->product_name }}</td>
                <td class="text-center">{{ $item->quantity }}</td>
                <td class="text-end">{{ $item->unit_price !== null ? '€ ' . number_format($item->unit_price, 2, ',', '.') : '-' }}</td>
                <td class="text-end">
                    <div class="d-flex gap-1 justify-content-end">
                        <a href="{{ route('order_items.show', $item->id) }}" class="btn btn-sm btn-outline-secondary">Bekijk</a>
                        <a href="{{ route('order_items.edit', $item->id) }}" class="btn btn-sm btn-outline-primary">Bewerk</a>
                        <form action="{{ route('order_items.destroy', $item->id) }}" method="POST">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger" onclick="return confirm('Weet je het zeker?')">Verwijder</button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr><td colspan="7" class="text-muted text-center py-4">Geen orderregels gevonden.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection