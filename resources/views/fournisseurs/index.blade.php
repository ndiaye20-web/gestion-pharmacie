@extends('layouts.app')

@section('content')

<h2 class="mb-4">Fournisseurs</h2>

<a href="{{ route('fournisseurs.create') }}" class="btn btn-primary mb-3">+ Ajouter</a>

@if(session('success'))
<div class="alert alert-success">{{ session('success') }}</div>
@endif

<table class="table table-bordered table-striped">
    <thead class="table-dark">
        <tr>
            <th>Nom</th>
            <th>Téléphone</th>
            <th>Email</th>
            <th>Actions</th>
        </tr>
    </thead>

    <tbody>
        @foreach($fournisseurs as $f)
        <tr>
            <td>{{ $f->nom }}</td>
            <td>{{ $f->telephone }}</td>
            <td>{{ $f->email }}</td>
            <td>
                <a href="{{ route('fournisseurs.edit', $f->id) }}" class="btn btn-warning btn-sm"></a>

                <form action="{{ route('fournisseurs.destroy', $f->id) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-danger btn-sm"></button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

@endsection
