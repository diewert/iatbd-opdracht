@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Admin Dashboard</h1>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <h2>Gebruikers</h2>
    <table class="table">
        <thead>
            <tr>
                <th>Naam</th>
                <th>Email</th>
                <th>Acties</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
            <div>
        <p>{{ $user->name }} - {{ $user->email }}</p>

        @if($user->is_blocked)
            <form action="{{ route('admin.unblock', $user->id) }}" method="POST">
                @csrf
                <button type="submit" class="btn-custom">Deblokkeer gebruiker</button>
            </form>
        @else
            <form action="{{ route('admin.block', $user->id) }}" method="POST">
                @csrf
                <button type="submit" class="btn-custom">Blokkeer gebruiker</button>
            </form>
        @endif
    </div>
            @endforeach
        </tbody>
    </table>

    <h2>Aanvragen</h2>
    <table class="table">
        <thead>
            <tr>
                <th>Huisdier</th>
                <th>Oppasser</th>
                <th>Acties</th>
            </tr>
        </thead>
        <tbody>
            @foreach($requests as $request)
                <tr>
                    <td>{{ $request->huisdier->naam }}</td>
                    <td>{{ $request->oppasser->user->name }}</td>
                    <td>
                        <form action="{{ route('admin.request.delete', $request->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-custom">Verwijder</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
