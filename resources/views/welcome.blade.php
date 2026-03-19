@extends('layouts.app')

@section('content')
<div class="row g-4 mb-4">
    <div class="col-12">
        <h1 class="fw-bold">Welkom bij Inventory System</h1>
        <p class="text-muted">Beheer uw producten, orders en voorraadbewegingen op een plek.</p>
    </div>
</div>

<div class="row g-4">
    <div class="col-md-4">
        <div class="card h-100 border-0 shadow-sm">
            <div class="card-body">
                <h5 class="card-title">Producten</h5>
                <p class="card-text text-muted">Beheer uw productcatalogus, SKUs en voorraadniveaus.</p>
                <a href="{{ route('products.index') }}" class="btn btn-primary btn-sm">Bekijk producten</a>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card h-100 border-0 shadow-sm">
            <div class="card-body">
                <h5 class="card-title">Marketplaces</h5>
                <p class="card-text text-muted">Verbind en configureer uw verkoopkanalen.</p>
                <a href="{{ route('marketplaces.index') }}" class="btn btn-primary btn-sm">Bekijk marketplaces</a>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card h-100 border-0 shadow-sm">
            <div class="card-body">
                <h5 class="card-title">Orders</h5>
                <p class="card-text text-muted">Bekijk en beheer inkomende orders van alle kanalen.</p>
                <a href="{{ route('orders.index') }}" class="btn btn-primary btn-sm">Bekijk orders</a>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card h-100 border-0 shadow-sm">
            <div class="card-body">
                <h5 class="card-title">Orderregels</h5>
                <p class="card-text text-muted">Beheer individuele producten binnen een order.</p>
                <a href="{{ route('order_items.index') }}" class="btn btn-outline-secondary btn-sm">Bekijk orderregels</a>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card h-100 border-0 shadow-sm">
            <div class="card-body">
                <h5 class="card-title">Orderadressen</h5>
                <p class="card-text text-muted">Beheer bezorg- en factuuradressen per order.</p>
                <a href="{{ route('order_addresses.index') }}" class="btn btn-outline-secondary btn-sm">Bekijk adressen</a>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card h-100 border-0 shadow-sm">
            <div class="card-body">
                <h5 class="card-title">Voorraadbewegingen</h5>
                <p class="card-text text-muted">Volg alle voorraadmutaties en houd de stock up-to-date.</p>
                <a href="{{ route('stock_movements.index') }}" class="btn btn-outline-secondary btn-sm">Bekijk bewegingen</a>
            </div>
        </div>
    </div>
</div>
@endsection
