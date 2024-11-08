@extends('layouts.app')

@section('content')
<div class="container my-4">
    <h1 class="text-center">Nieuw Huisdier Toevoegen</h1>

    <form action="{{ route('huisdier.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <!-- Naam -->
        <div class="mb-3">
            <label for="naam" class="form-label">Naam van het huisdier</label>
            <input type="text" class="form-control" id="naam" name="naam" value="{{ old('naam') }}" required>
        </div>

        <!-- Soort -->
        <div class="mb-3">
            <label for="soort" class="form-label">Soort Huisdier</label>
            <select class="form-control" id="soort" name="soort" required>
                <option value="" disabled selected>Kies een soort</option>
                <option value="hond" {{ old('soort') == 'hond' ? 'selected' : '' }}>Hond</option>
                <option value="kat" {{ old('soort') == 'kat' ? 'selected' : '' }}>Kat</option>
                <option value="schildpad" {{ old('soort') == 'schildpad' ? 'selected' : '' }}>Schildpad</option>
                <option value="konijn" {{ old('soort') == 'konijn' ? 'selected' : '' }}>Konijn</option>
            </select>
        </div>

        <!-- Uurtarief -->
        <div class="mb-3">
            <label for="uurtarief" class="form-label">Uurtarief (€)</label>
            <input type="number" step="0.01" class="form-control" id="uurtarief" name="uurtarief" value="{{ old('uurtarief') }}" required>
        </div>

        <!-- Begin datum -->
        <div class="mb-3">
            <label for="begin_datum" class="form-label">Begin datum</label>
            <input type="date" class="form-control" id="begin_datum" name="begin_datum" value="{{ old('begin_datum') }}" required>
        </div>

        <!-- Eind datum -->
        <div class="mb-3">
            <label for="eind_datum" class="form-label">Eind datum</label>
            <input type="date" class="form-control" id="eind_datum" name="eind_datum" value="{{ old('eind_datum') }}" required>
        </div>

        <!-- Achtergrond informatie -->
        <div class="mb-3">
            <label for="achtergrond_informatie" class="form-label">Achtergrond Informatie</label>
            <textarea class="form-control" id="achtergrond_informatie" name="achtergrond_informatie" rows="3">{{ old('achtergrond_informatie') }}</textarea>
        </div>

        <!-- Foto -->
        <div class="mb-3">
            <label for="foto" class="form-label">Foto van het huisdier</label>
            <input type="file" class="form-control" id="foto" name="foto" accept="image/*">
        </div>

        <button type="submit" class="btn-custom">Huisdier Toevoegen</button>
    </form>
</div>
@endsection
