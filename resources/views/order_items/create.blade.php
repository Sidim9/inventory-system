@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-7">
        <h1 class="mb-4">Product toevoegen aan order</h1>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Pass product data as JSON for auto-fill --}}
        @php
            $productData = $products->keyBy('id')->map(fn($p) => [
                'ean'   => $p->ean,
                'sku'   => $p->sku,
                'name'  => $p->name,
                'price' => $p->price,
            ]);
        @endphp

        <form action="{{ route('order_items.store') }}" method="POST">
            @csrf
            <div class="row g-3">
                <div class="col-12">
                    <label class="form-label">Order <span class="text-danger">*</span></label>
                    <select name="order_id" class="form-select" required>
                        <option value="">-- Selecteer order --</option>
                        @foreach ($orders as $order)
                            <option value="{{ $order->id }}" {{ old('order_id', request('order_id')) == $order->id ? 'selected' : '' }}>
                                {{ $order->order_number }}{{ $order->customer_name ? ' — ' . $order->customer_name : '' }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-12">
                    <label class="form-label">Product (optioneel — vult velden automatisch in)</label>
                    <select id="productSelect" name="product_id" class="form-select">
                        <option value="">-- Geen product --</option>
                        @foreach ($products as $product)
                            <option value="{{ $product->id }}" {{ old('product_id') == $product->id ? 'selected' : '' }}>
                                {{ $product->name }} — {{ $product->ean ?: $product->sku }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label">EAN</label>
                    <input type="text" id="field_ean" name="ean" class="form-control" value="{{ old('ean') }}">
                </div>
                <div class="col-md-6">
                    <label class="form-label">SKU</label>
                    <input type="text" id="field_sku" name="sku" class="form-control" value="{{ old('sku') }}">
                </div>
                <div class="col-md-8">
                    <label class="form-label">Productnaam <span class="text-danger">*</span></label>
                    <input type="text" id="field_name" name="product_name" class="form-control" value="{{ old('product_name') }}" required>
                </div>
                <div class="col-md-2">
                    <label class="form-label">Stukprijs (€)</label>
                    <input type="number" step="0.01" id="field_price" name="unit_price" class="form-control" value="{{ old('unit_price') }}">
                </div>
                <div class="col-md-2">
                    <label class="form-label">Aantal <span class="text-danger">*</span></label>
                    <input type="number" name="quantity" class="form-control" value="{{ old('quantity', 1) }}" min="1" required>
                </div>
            </div>
            <div class="mt-4">
                <button type="submit" class="btn btn-primary">Toevoegen</button>
                <a href="{{ route('order_items.index') }}" class="btn btn-secondary">Annuleren</a>
            </div>
        </form>
    </div>
</div>

<script>
const productData = @json($productData);
document.getElementById('productSelect').addEventListener('change', function () {
    const p = productData[this.value];
    if (!p) return;
    document.getElementById('field_ean').value   = p.ean   || '';
    document.getElementById('field_sku').value   = p.sku   || '';
    document.getElementById('field_name').value  = p.name  || '';
    document.getElementById('field_price').value = p.price || '';
});
</script>
@endsection