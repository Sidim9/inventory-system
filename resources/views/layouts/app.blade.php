<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'Inventory System') }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm">
        <div class="container">
            <a class="navbar-brand fw-semibold" href="{{ url('/') }}">📦 Inventory</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMain">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarMain">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('/') ? 'active' : '' }}" href="{{ url('/') }}">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('products.*') ? 'active' : '' }}" href="{{ route('products.index') }}">Producten</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('marketplaces.*') ? 'active' : '' }}" href="{{ route('marketplaces.index') }}">Marketplaces</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('orders.*') ? 'active' : '' }}" href="{{ route('orders.index') }}">Orders</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('order_items.*') ? 'active' : '' }}" href="{{ route('order_items.index') }}">Orderregels</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('order_addresses.*') ? 'active' : '' }}" href="{{ route('order_addresses.index') }}">Orderadressen</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('stock_movements.*') ? 'active' : '' }}" href="{{ route('stock_movements.index') }}">Voorraadbewegingen</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <main class="container my-4">
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @yield('content')
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
