@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <h1 class="mb-4">Marketplace</h1>
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <dl class="row mb-0">
                    <dt class="col-sm-4">Naam</dt><dd class="col-sm-8">{{ $marketplace->name }}</dd>
                    <dt class="col-sm-4">Code</dt><dd class="col-sm-8">{{ $marketplace->code }}</dd>
                    <dt class="col-sm-4">API base URL</dt><dd class="col-sm-8">{{ $marketplace->api_base_url ?: '-' }}</dd>
                    <dt class="col-sm-4">Actief</dt><dd class="col-sm-8">{{ $marketplace->is_active ? 'Ja' : 'Nee' }}</dd>
                </dl>
            </div>
        </div>
        <div class="mt-3 d-flex gap-2">
            <a href="{{ route('marketplaces.edit', $marketplace->id) }}" class="btn btn-primary">Bewerk</a>
            <a href="{{ route('marketplaces.index') }}" class="btn btn-secondary">Terug</a>
        </div>
    </div>
</div>
@endsection