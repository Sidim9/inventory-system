@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <div>
        <h1>{{ $picklist->name }}</h1>
        <p class="text-muted mb-0">
            {{ $picklist->orders->count() }} order(s) &mdash; {{ $picklist->total_items }} artikel(en)
            &mdash; aangemaakt op {{ $picklist->created_at->format('d-m-Y H:i') }}
        </p>
    </div>
    <a href="{{ route('orders.index') }}" class="btn btn-outline-secondary">Terug naar orders</a>
</div>

@if (session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<div class="table-responsive">
    <table class="table table-hover bg-white shadow-sm rounded">
        <thead class="table-light">
            <tr>
                <th>Ordernummer</th>
                <th>Klant</th>
                <th>Status</th>
                <th>Besteldatum</th>
                <th>Regels</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @forelse ($picklist->orders as $order)
            @php $statusColors = ['pending'=>'warning','processing'=>'info','shipped'=>'primary','delivered'=>'success','cancelled'=>'danger']; @endphp
            <tr>
                <td><strong>{{ $order->order_number }}</strong></td>
                <td>{{ $order->customer_name ?: '-' }}{{ $order->company_name ? ' (' . $order->company_name . ')' : '' }}</td>
                <td><span class="badge bg-{{ $statusColors[$order->status] ?? 'secondary' }}">{{ $order->status }}</span></td>
                <td>{{ $order->ordered_at?->format('d-m-Y') ?? '-' }}</td>
                <td>{{ $order->items->count() }}</td>
                <td class="text-end">
                    <a href="{{ route('orders.show', $order->id) }}" class="btn btn-sm btn-outline-secondary">Bekijk</a>
                </td>
            </tr>
            @empty
            <tr><td colspan="6" class="text-muted text-center py-4">Geen orders in deze picklijst.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
