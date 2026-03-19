@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h1>Order {{ $order->order_number }}</h1>
    <div class="d-flex gap-2">
        <a href="{{ route('orders.edit', $order->id) }}" class="btn btn-outline-primary">Bewerk order</a>
        <a href="{{ route('orders.index') }}" class="btn btn-secondary">Terug</a>
    </div>
</div>

<div class="row g-4">
    {{-- Order + klantgegevens --}}
    <div class="col-md-6">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-white fw-semibold">Ordergegevens</div>
            <div class="card-body">
                <dl class="row mb-0">
                    <dt class="col-sm-5">Ordernummer</dt><dd class="col-sm-7">{{ $order->order_number }}</dd>
                    <dt class="col-sm-5">Bron</dt><dd class="col-sm-7">{{ $order->source ?: '-' }}</dd>
                    <dt class="col-sm-5">Status</dt>
                    <dd class="col-sm-7">
                        @php $statusColors = ['pending'=>'warning','processing'=>'info','shipped'=>'primary','delivered'=>'success','cancelled'=>'danger']; @endphp
                        <span class="badge bg-{{ $statusColors[$order->status] ?? 'secondary' }}">{{ $order->status }}</span>
                    </dd>
                    <dt class="col-sm-5">Besteldatum</dt><dd class="col-sm-7">{{ $order->ordered_at?->format('d-m-Y H:i') ?? '-' }}</dd>
                    <dt class="col-sm-5">Notities</dt><dd class="col-sm-7">{{ $order->notes ?: '-' }}</dd>
                </dl>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-white fw-semibold">Klant &amp; Bezorgadres</div>
            <div class="card-body">
                <dl class="row mb-0">
                    <dt class="col-sm-5">Naam</dt><dd class="col-sm-7">{{ $order->customer_name ?: '-' }}</dd>
                    <dt class="col-sm-5">E-mail</dt><dd class="col-sm-7">{{ $order->customer_email ?: '-' }}</dd>
                    <dt class="col-sm-5">Telefoon</dt><dd class="col-sm-7">{{ $order->phone ?: '-' }}</dd>
                    <dt class="col-sm-5">Adres</dt>
                    <dd class="col-sm-7">
                        @if($order->street)
                            {{ $order->street }} {{ $order->house_number }}{{ $order->house_number_addition ? ' ' . $order->house_number_addition : '' }}<br>
                            {{ $order->postal_code }} {{ $order->city }}<br>
                            {{ $order->country }}
                        @else
                            -
                        @endif
                    </dd>
                </dl>
            </div>
        </div>
    </div>
</div>

{{-- Order items --}}
<div class="mt-4">
    <div class="d-flex justify-content-between align-items-center mb-2">
        <h5 class="mb-0">Orderregels</h5>
        <a href="{{ route('order_items.create', ['order_id' => $order->id]) }}" class="btn btn-sm btn-primary">+ Product toevoegen</a>
    </div>
    <div class="table-responsive">
        <table class="table table-hover bg-white shadow-sm rounded">
            <thead class="table-light">
                <tr>
                    <th>EAN</th>
                    <th>SKU</th>
                    <th>Productnaam</th>
                    <th class="text-center">Aantal</th>
                    <th class="text-end">Stukprijs</th>
                    <th class="text-end">Totaal</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse ($order->items as $item)
                <tr>
                    <td>{{ $item->ean ?: '-' }}</td>
                    <td><code>{{ $item->sku ?: '-' }}</code></td>
                    <td>{{ $item->product_name }}</td>
                    <td class="text-center">{{ $item->quantity }}</td>
                    <td class="text-end">{{ $item->unit_price !== null ? '€ ' . number_format($item->unit_price, 2, ',', '.') : '-' }}</td>
                    <td class="text-end">{{ $item->unit_price !== null ? '€ ' . number_format($item->unit_price * $item->quantity, 2, ',', '.') : '-' }}</td>
                    <td class="text-end">
                        <form action="{{ route('order_items.destroy', $item->id) }}" method="POST" class="d-inline">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger" onclick="return confirm('Verwijder deze orderregel?')">Verwijder</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="7" class="text-muted text-center py-3">Nog geen producten toegevoegd.</td></tr>
                @endforelse
            </tbody>
            @if($order->items->isNotEmpty())
            <tfoot class="table-light fw-semibold">
                <tr>
                    <td colspan="5" class="text-end">Totaal:</td>
                    <td class="text-end">€ {{ number_format($order->items->sum(fn($i) => $i->unit_price * $i->quantity), 2, ',', '.') }}</td>
                    <td></td>
                </tr>
            </tfoot>
            @endif
        </table>
    </div>
</div>

{{-- Delete order --}}
<div class="mt-3">
    <form action="{{ route('orders.destroy', $order->id) }}" method="POST" class="d-inline">
        @csrf @method('DELETE')
        <button class="btn btn-outline-danger btn-sm" onclick="return confirm('Order en alle orderregels verwijderen?')">Order verwijderen</button>
    </form>
</div>
@endsection