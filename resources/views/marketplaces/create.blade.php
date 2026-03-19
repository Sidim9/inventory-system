@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <h1 class="mb-4">Nieuwe marketplace</h1>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('marketplaces.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label class="form-label">Naam</label>
                <input type="text" name="name" class="form-control" value="{{ old('name') }}">
            </div>
            <div class="mb-3">
                <label class="form-label">Code</label>
                <input type="text" name="code" class="form-control" value="{{ old('code') }}">
            </div>
            <div class="mb-3">
                <label class="form-label">API base URL</label>
                <input type="text" name="api_base_url" class="form-control" value="{{ old('api_base_url') }}">
            </div>
            <div class="mb-3 form-check">
                <input type="checkbox" name="is_active" value="1" class="form-check-input" id="isActive" checked>
                <label class="form-check-label" for="isActive">Actief</label>
            </div>
            <button type="submit" class="btn btn-primary">Opslaan</button>
            <a href="{{ route('marketplaces.index') }}" class="btn btn-secondary">Annuleren</a>
        </form>
    </div>
</div>
@endsection