@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h1>Marketplaces</h1>
    <a href="{{ route('marketplaces.create') }}" class="btn btn-primary">Nieuwe marketplace</a>
</div>

@forelse ($marketplaces as $marketplace)
    <div class="card mb-2 border-0 shadow-sm">
        <div class="card-body d-flex justify-content-between align-items-center">
            <span>
                <strong>{{ $marketplace->name }}</strong> &mdash;
                {{ $marketplace->code }}
                &mdash; {!! $marketplace->is_active ? '<span class="badge bg-success">Actief</span>' : '<span class="badge bg-secondary">Inactief</span>' !!}
            </span>
            <div class="d-flex gap-2">
                <a href="{{ route('marketplaces.show', $marketplace->id) }}" class="btn btn-sm btn-outline-secondary">Bekijk</a>
                <a href="{{ route('marketplaces.edit', $marketplace->id) }}" class="btn btn-sm btn-outline-primary">Bewerk</a>
                <form action="{{ route('marketplaces.destroy', $marketplace->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Weet je het zeker?')">Verwijder</button>
                </form>
            </div>
        </div>
    </div>
@empty
    <p class="text-muted">Geen marketplaces gevonden.</p>
@endforelse
@endsection