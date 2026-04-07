@extends('layouts.app')

@section('content')
<h1 class="fw-bold mb-1">Dashboard</h1>
<p class="text-muted mb-4">Overzicht van het inventory systeem.</p>

{{-- KPI cards --}}
<div class="row g-4 mb-4">
    <div class="col-md-3 col-sm-6">
        <div class="card border-0 shadow-sm text-center">
            <div class="card-body py-4">
                <div class="display-6 fw-bold text-primary">{{ $totalOrders }}</div>
                <div class="text-muted small mt-1">Actieve orders</div>
            </div>
            <div class="card-footer bg-white border-0 pb-3">
                <a href="{{ route('orders.index') }}" class="btn btn-sm btn-outline-primary">Bekijk orders</a>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-sm-6">
        <div class="card border-0 shadow-sm text-center">
            <div class="card-body py-4">
                <div class="display-6 fw-bold text-secondary">{{ $totalPicklists }}</div>
                <div class="text-muted small mt-1">Picklijsten</div>
            </div>
            <div class="card-footer bg-white border-0 pb-3">
                <a href="{{ route('picklists.index') }}" class="btn btn-sm btn-outline-secondary">Bekijk picklijsten</a>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-sm-6">
        <div class="card border-0 shadow-sm text-center">
            <div class="card-body py-4">
                <div class="display-6 fw-bold {{ $lowStockProducts->count() > 0 ? 'text-danger' : 'text-muted' }}">
                    {{ $lowStockProducts->count() }}
                </div>
                <div class="text-muted small mt-1">Lage voorraad</div>
            </div>
            <div class="card-footer bg-white border-0 pb-3">
                <a href="{{ route('products.index') }}" class="btn btn-sm btn-outline-danger">Bekijk producten</a>
            </div>
        </div>
    </div>
</div>

<div class="row g-4">
    {{-- Low stock products --}}
    @if ($lowStockProducts->isNotEmpty())
    <div class="col-md-5">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white fw-semibold text-danger">⚠ Lage voorraad</div>
            <ul class="list-group list-group-flush">
                @foreach ($lowStockProducts as $product)
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <a href="{{ route('products.show', $product->id) }}" class="text-decoration-none text-dark">
                        <strong>{{ $product->ean }} -> {{ $product->name }}</strong>
                    </a>
                    <span class="badge bg-danger">{{ $product->stock }} / min {{ $product->minimum_stock }}</span>
                </li>
                @endforeach
            </ul>
        </div>
    </div>
    @endif

    {{-- Latest orders --}}
    <div class="col">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white fw-semibold">Actieve orders</div>
            @if ($latestOrders->isEmpty())
                <div class="card-body text-muted">Nog geen orders aangemaakt.</div>
            @else
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Ordernummer</th>
                            <th>Klant</th>
                            <th>Status</th>
                            <th>Datum</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($latestOrders as $order)
                        <tr>
                            <td><strong><a href="{{ route('orders.show', $order->id) }}" class="text-decoration-none text-dark">{{ $order->order_number }}</a></strong></td>
                            <td>{{ $order->customer_name ?: '-' }}</td>
                            <td><span class="badge bg-{{ $order->status->color() }}">{{ $order->status->label() }}</span></td>
                            <td>{{ $order->ordered_at?->format('d-m-Y') ?? '-' }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection

