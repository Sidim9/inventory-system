@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h1>Orders</h1>
    <a href="{{ route('orders.create') }}" class="btn btn-primary">Nieuwe order</a>
</div>

<div class="table-responsive">
    <table class="table table-hover bg-white shadow-sm rounded">
        <thead class="table-light">
            <tr>
                <th>Ordernummer</th>
                <th>Bron</th>
                <th>Klant</th>
                <th>Status</th>
                <th>Besteldatum</th>
                <th>Regels</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @forelse ($orders as $order)
            @php $statusColors = ['pending'=>'warning','processing'=>'info','shipped'=>'primary','delivered'=>'success','cancelled'=>'danger']; @endphp
            <tr>
                <td><strong>{{ $order->order_number }}</strong></td>
                <td>{{ $order->source ?: '-' }}</td>
                <td>{{ $order->customer_name ?: '-' }}</td>
                <td><span class="badge bg-{{ $statusColors[$order->status] ?? 'secondary' }}">{{ $order->status }}</span></td>
                <td>{{ $order->ordered_at?->format('d-m-Y') ?? '-' }}</td>
                <td>{{ $order->items_count ?? '-' }}</td>
                <td class="text-end">
                    <div class="d-flex gap-1 justify-content-end">
                        <a href="{{ route('orders.show', $order->id) }}" class="btn btn-sm btn-outline-secondary">Bekijk</a>
                        <a href="{{ route('orders.edit', $order->id) }}" class="btn btn-sm btn-outline-primary">Bewerk</a>
                        <form action="{{ route('orders.destroy', $order->id) }}" method="POST">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger" onclick="return confirm('Weet je het zeker?')">Verwijder</button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr><td colspan="7" class="text-muted text-center py-4">Geen orders gevonden.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection