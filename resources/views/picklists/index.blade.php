@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h1>Picklijsten</h1>
    <a href="{{ route('orders.index') }}" class="btn btn-outline-secondary">← Terug naar orders</a>
</div>

@if ($picklists->isEmpty())
    <p class="text-muted">Nog geen picklijsten aangemaakt.</p>
@else
<div class="table-responsive">
    <table class="table table-hover bg-white shadow-sm rounded">
        <thead class="table-light">
            <tr>
                <th>Naam</th>
                <th class="text-center">Orders</th>
                <th class="text-center">Artikelen</th>
                <th>Aangemaakt op</th>
                <th>Verwerkt op</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($picklists as $picklist)
            <tr>
                <td><strong><a href="{{ route('picklists.show', $picklist->id) }}" class="text-decoration-none text-dark">{{ $picklist->name }}</a></strong></td>
                <td class="text-center">{{ $picklist->orders_count }}</td>
                <td class="text-center">{{ $picklist->total_items }}</td>
                <td>{{ $picklist->created_at->format('d-m-Y H:i') }}</td>
                <td>
                    @if ($picklist->processed_at)
                        <span class="badge bg-success">{{ $picklist->processed_at->format('d-m-Y H:i') }}</span>
                    @else
                        <span class="text-muted">—</span>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endif
@endsection
