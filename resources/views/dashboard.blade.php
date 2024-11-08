@extends('layouts.app')

@section('content')
<div class="container my-4">
    <h1 class="text-center">Dashboard</h1>

    <!-- Success message -->
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <!-- Error message -->
    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <!-- Knop om je aan te melden als oppasser -->
    <div class="text-center mt-4">
        <a href="{{ route('oppasser.create') }}" class="btn-custom">Meld je aan als Oppasser</a>
    </div>

    <div class="row mt-4">
        <!-- Linker kolom voor huisdieren aanmeldingen -->
        <div class="col-md-6">
            <h4 class="kopjes">Aanmeldingen voor jouw huisdieren</h4> <!-- Vetgedrukt en groter -->
            @foreach($huisdieren as $huisdier)
                @if($huisdier->aanmeldingen->isNotEmpty())
                    <h5>{{ $huisdier->naam }}</h5>
                    @foreach($huisdier->aanmeldingen as $aanmelding)
                        <div class="card mb-3" style="border-left: 5px solid {{ $aanmelding->status == 'pending' ? 'yellow' : ($aanmelding->status == 'accepted' ? 'green' : 'red') }};">
                            <div class="card-body">
                                <h5 class="card-title">{{ $aanmelding->oppasser->user->name }}</h5>
                                <p class="card-text">Status: {{ ucfirst($aanmelding->status) }}</p>

                                @if($aanmelding->status == 'pending')
                                    <form action="{{ route('passen.update', $aanmelding->id) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" name="action" value="accept" class="btn-custom">Accepteren</button>
                                        <button type="submit" name="action" value="reject" class="btn-custom">Weigeren</button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    @endforeach
                @else
                    <p>Er zijn momenteel geen aanmeldingen voor {{ $huisdier->naam }}.</p>
                @endif
            @endforeach
        </div>

        <!-- Rechter kolom voor aanmeldingen van de oppasser -->
        <div class="col-md-6">
            <h4 class="kopjes">Aanmeldingen van jou</h4> <!-- Vetgedrukt en groter -->
            @if($aanmeldingen->isNotEmpty())
                @foreach($aanmeldingen as $aanmelding)
                    <div class="card mb-3" style="border-left: 5px solid {{ $aanmelding->status == 'pending' ? 'yellow' : ($aanmelding->status == 'accepted' ? 'green' : 'red') }};">
                        <div class="card-body">
                            <h5 class="card-title">Huisdier: {{ $aanmelding->huisdier->naam }}</h5>
                            <p class="card-text">Status: {{ ucfirst($aanmelding->status) }}</p>
                        </div>
                    </div>
                @endforeach
            @else
                <p>Je hebt geen actieve aanmeldingen.</p>
            @endif
        </div>
    </div>
</div>
@endsection
