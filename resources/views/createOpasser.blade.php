@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="text-center">Aanmelden als Oppasser</h1>

    <form action="{{ route('oppassers.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <!-- Profielfoto -->
        <div class="mb-3">
            <label for="profielfoto" class="form-label">Profielfoto</label>
            <input type="file" class="form-control" id="profielfoto" name="profielfoto" accept="image/*">
        </div>

        <!-- Huisfoto -->
        <div class="mb-3">
            <label for="huisfoto" class="form-label">Foto van je huis</label>
            <input type="file" class="form-control" id="huisfoto" name="huisfoto" accept="image/*">
        </div>

        <!-- Beschrijving -->
        <div class="mb-3">
            <label for="beschrijving" class="form-label">Beschrijf jezelf als oppasser</label>
            <textarea class="form-control" id="beschrijving" name="beschrijving" rows="3"></textarea>
        </div>

        <button type="submit" class="btn-custom">Aanmelden als Oppasser</button>
    </form>
</div>
@endsection
