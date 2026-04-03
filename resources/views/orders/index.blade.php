@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h1>Orders</h1>
    <a href="{{ route('orders.create') }}" class="btn btn-primary">Nieuwe order</a>
</div>

@if (session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif
@if (session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
@endif

<form action="{{ route('picklists.generate') }}" method="POST">
    @csrf

    <div class="d-flex justify-content-between align-items-center mb-2">
        <div class="text-muted small">Selecteer orders om een picklijst te genereren.</div>
        <button type="submit" class="btn btn-success">
            Verwerken als picklijst
        </button>
    </div>

    @error('order_ids')
        <div class="alert alert-danger">{{ $message }}</div>
    @enderror

    <div class="table-responsive">
        <table class="table table-hover bg-white shadow-sm rounded">
            <thead class="table-light">
                <tr>
                    <th style="width: 40px;">
                        <input type="checkbox" id="select-all" title="Alles selecteren">
                    </th>
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
                <tr>
                    <td>
                        <input type="checkbox"
                               name="order_ids[]"
                               value="{{ $order->id }}"
                               class="order-checkbox">
                    </td>
                    <td><strong>{{ $order->order_number }}</strong></td>
                    <td>{{ $order->source ?: '-' }}</td>
                    <td>{{ $order->customer_name ?: '-' }}{{ $order->company_name ? ' (' . $order->company_name . ')' : '' }}</td>
                    <td><span class="badge bg-{{ $order->status->color() }}">{{ $order->status->label() }}</span></td>
                    <td>{{ $order->ordered_at?->format('d-m-Y') ?? '-' }}</td>
                    <td>{{ $order->items_count }}</td>
                    <td class="text-end">
                        <div class="d-flex gap-1 justify-content-end">
                            <a href="{{ route('orders.show', $order->id) }}" class="btn btn-sm btn-outline-secondary">Bekijk</a>
                            <a href="{{ route('orders.edit', $order->id) }}" class="btn btn-sm btn-outline-primary">Bewerk</a>
                            <button type="button"
                                    class="btn btn-sm btn-outline-danger"
                                    onclick="if(confirm('Weet je het zeker?')) { document.getElementById('delete-{{ $order->id }}').submit(); }">
                                Verwijder
                            </button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="8" class="text-muted text-center py-4">Geen actieve orders gevonden.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</form>

{{-- Separate delete forms outside the picklist form to avoid nesting --}}
@foreach ($orders as $order)
<form id="delete-{{ $order->id }}" action="{{ route('orders.destroy', $order->id) }}" method="POST" class="d-none">
    @csrf @method('DELETE')
</form>
@endforeach

<script>
document.getElementById('select-all')?.addEventListener('change', function () {
    document.querySelectorAll('.order-checkbox').forEach(cb => cb.checked = this.checked);
});
</script>
@endsection