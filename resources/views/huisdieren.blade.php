@extends('layouts.app')

@section('content')
<div class="container my-4">
    <h1 class="text-center">Jouw aangemelde huisdieren</h1>

    <!-- Knop voor nieuw huisdier toevoegen, met extra margin-bottom -->
    <div class="d-flex justify-content-center mb-5">
        <a href="{{ route('huisdier.create') }}" class="btn btn-custom btn-lg">Nieuw huisdier toevoegen</a>
    </div>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if($huisdieren->isEmpty())
        <p>Je hebt nog geen huisdieren toegevoegd.</p>
    @else
        <div class="row justify-content-center"> <!-- Cards gecentreerd -->
            @foreach($huisdieren as $huisdier)
                <div class="col-md-3 col-sm-6 mb-4"> <!-- Pas de kolombreedte aan voor kleinere schermen -->
                    <div class="card shadow-sm border-light" style="height: 100%;"> <!-- Voeg schaduw toe en stel de hoogte in -->
                        <img src="{{ asset('storage/' . $huisdier->foto) }}" class="card-img-top img-fluid" alt="{{ $huisdier->naam }}" style="max-height: 150px; object-fit: cover;"> <!-- Maak de afbeelding kleiner -->
                        <div class="card-body">
                            <h5 class="card-title">{{ $huisdier->naam }}</h5>
                            <p class="card-text">
                                <strong>Soort:</strong> {{ $huisdier->soort }}<br>
                                <strong>Uurtarief:</strong> €{{ $huisdier->uurtarief }}<br>
                                <strong>Begin Datum:</strong> {{ $huisdier->begin_datum }}<br>
                                <strong>Eind Datum:</strong> {{ $huisdier->eind_datum }}<br>
                                <strong>Achtergrondinformatie:</strong> {{ $huisdier->achtergrond_informatie }}<br>
                            </p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
