@extends('layouts.app')

@section('content')
<div class="container my-4">
    <h1 class="text-center display-4">Alle Huisdieren</h1> <!-- Grotere titel -->

    <!-- Filter Section -->
    <div class="text-center mb-4">
        <form method="GET" action="{{ route('huisdieren.aanvragen') }}" class="d-inline-block">
            <div class="row mb-3 justify-content-center">
                <div class="col-md-4">
                    <label for="soort" class="form-label">Soort Huisdier</label>
                    <select name="soort" id="soort" class="form-select">
                        <option value="">Alle</option>
                        <option value="hond" {{ request('soort') == 'hond' ? 'selected' : '' }}>Hond</option>
                        <option value="kat" {{ request('soort') == 'kat' ? 'selected' : '' }}>Kat</option>
                        <option value="schildpad" {{ request('soort') == 'schildpad' ? 'selected' : '' }}>Schildpad</option>
                        <option value="konijn" {{ request('soort') == 'konijn' ? 'selected' : '' }}>Konijn</option>
                    </select>
                </div>

                <div class="col-md-4">
                    <label for="min_uurtarief" class="form-label">Minimaal Uurtarief (€)</label>
                    <input type="number" name="min_uurtarief" id="min_uurtarief" class="form-control" value="{{ request('min_uurtarief') }}" step="0.01">
                </div>

                <div class="col-md-4">
                    <label for="max_uurtarief" class="form-label">Maximaal Uurtarief (€)</label>
                    <input type="number" name="max_uurtarief" id="max_uurtarief" class="form-control" value="{{ request('max_uurtarief') }}" step="0.01">
                </div>
            </div>
            
            <div class="text-center mb-3">
                <button type="submit" class="btn-custom">Filter</button>
                <a href="{{ route('huisdieren.aanvragen') }}" class="btn btn-secondary ms-2">Reset Filters</a> <!-- Reset knop -->
            </div>
        </form>
    </div>

    @if($huisdieren->isEmpty())
        <p>Er zijn momenteel geen huisdieren aangemeld.</p>
    @else
        <div class="row justify-content-center">
            @foreach($huisdieren as $huisdier)
                <div class="col-md-3 col-sm-6 mb-4">
                    <div class="card shadow-sm border-light">
                        <img src="{{ asset('storage/' . $huisdier->foto) }}" class="card-img-top img-fluid" alt="{{ $huisdier->naam }}" style="max-height: 150px; object-fit: cover;">
                        <div class="card-body">
                            <h5 class="card-title">{{ $huisdier->naam }}</h5>
                            <p class="card-text">
                                <strong>Eigenaar:</strong> {{ $huisdier->user->name }}<br>
                                <strong>Soort:</strong> {{ $huisdier->soort }}<br>
                                <strong>Uurtarief:</strong> €{{ $huisdier->uurtarief }}<br>
                                <strong>Begin Datum:</strong> {{ $huisdier->begin_datum }}<br>
                                <strong>Eind Datum:</strong> {{ $huisdier->eind_datum }}<br>
                                <strong>Achtergrondinformatie:</strong> {{ $huisdier->achtergrond_informatie }}<br>
                            </p>
                            @if(Auth::check() && Auth::user()->isOppasser())
    <form action="{{ route('passen.store', $huisdier->id) }}" method="POST">
        @csrf
        <input type="hidden" name="oppasser_id" value="{{ Auth::user()->id }}">
        <button type="submit" class="btn-custom">Aanmelden om op dit huisdier te passen</button>
    </form>
@else
    <p>Je moet je aanmelden als oppasser om je aan te melden voor dit huisdier.</p>
@endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
