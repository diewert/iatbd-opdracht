@extends('layouts.app')

@section('content')
<div class="container my-4">
    <h1 class="text-center">Alle Oppassers</h1>

    @if($oppassers->isEmpty())
        <p>Er zijn momenteel geen oppassers beschikbaar.</p>
    @else
        <div class="row justify-content-center">
            @foreach($oppassers as $oppasser)
                <div class="col-md-4 col-sm-6 mb-4">
                    <div class="card shadow-sm border-light">
                        <img src="{{ asset('storage/' . $oppasser->profielfoto) }}" class="card-img-top img-fluid" alt="{{ $oppasser->user->name }}" style="max-height: 200px; object-fit: cover;">
                        <div class="card-body">
                            <h5 class="card-title">{{ $oppasser->user->name }}</h5>
                            <p class="card-text">{{ $oppasser->beschrijving }}</p>
                            <a href="{{ route('oppassers.show', $oppasser->id) }}" class="btn-custom">Bekijk profiel</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
