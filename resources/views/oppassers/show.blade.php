@extends('layouts.app')

@section('content')
<div class="container my-4">
    <h1 class="text-center">{{ $oppasser->user->name }}'s Profiel</h1>

    <div class="row">
        <!-- Profielfoto links -->
        <div class="col-md-3 mb-4"> <!-- Maak de kolom smaller -->
            <div class="card shadow-sm border-light"> <!-- Voeg schaduw toe -->
                @if($oppasser->profielfoto)
                    <img src="{{ asset('storage/' . $oppasser->profielfoto) }}" class="card-img-top img-fluid" alt="Profielfoto van {{ $oppasser->user->name }}" style="max-height: 150px; object-fit: cover;"> <!-- Maak de afbeelding kleiner -->
                @else
                    <p>Geen profielfoto beschikbaar.</p>
                @endif
            </div>
        </div>

        <!-- Beschrijving rechts -->
        <div class="col-md-9">
            <div class="card mb-4"> <!-- Extra marge onder de beschrijving kaart -->
                <div class="card-body">
                    <h4>Beschrijving</h4>
                    <p>{{ $oppasser->beschrijving }}</p>

                    <!-- Huisfoto -->
                    <h4>Foto van het huis</h4>
                    @if($oppasser->huisfoto)
                        <img src="{{ asset('storage/' . $oppasser->huisfoto) }}" class="img-fluid rounded" alt="Foto van het huis van {{ $oppasser->user->name }}" style="max-height: 250px; object-fit: cover;">
                    @else
                        <p>Geen foto van het huis beschikbaar.</p>
                    @endif
                </div>
            </div>
        </div>

        <!-- Formulier voor review -->
        <div class="col-md-12">
            @if(auth()->check())
                <form action="{{ route('oppassers.storeReview', $oppasser->id) }}" method="POST" class="mt-4 mb-4"> <!-- Extra marges boven en onder -->
                    @csrf
                    <div class="form-group mb-3"> <!-- Marge onder het form veld -->
                        <label for="review">Laat een review achter:</label>
                        <textarea name="review" id="review" class="form-control" required></textarea>
                    </div>
                    <button type="submit" class="btn-custom">Review verzenden</button>
                </form>
            @endif
        </div>

        <!-- Reviews -->
        <div class="col-md-12">
            <h3 class="mt-4">Reviews:</h3> <!-- Marge boven de reviews sectie -->
            @if($reviewsWithNames && count($reviewsWithNames) > 0)
                @foreach($reviewsWithNames as $review)
                    <div class="card mb-2">
                        <div class="card-body">
                            <p>{{ $review['review'] }}</p>
                            <small>Geplaatst door gebruiker: {{ $review['user_name'] }}</small>
                        </div>
                    </div>
                @endforeach
            @else
                <p>Geen reviews beschikbaar.</p>
            @endif
        </div>
    </div>
</div>
@endsection
