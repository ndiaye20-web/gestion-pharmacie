@extends('layouts.app')

@section('content')

<h2>Modifier Fournisseur</h2>

<form method="POST" action="{{ route('fournisseurs.update', $fournisseur->id) }}">
    @csrf
    @method('PUT')

    <div class="mb-3">
        <label>Nom</label>
        <input type="text" name="nom" value="{{ $fournisseur->nom }}" class="form-control">
    </div>

    <div class="mb-3">
        <label>Téléphone</label>
        <input type="text" name="telephone" value="{{ $fournisseur->telephone }}" class="form-control">
    </div>

    <div class="mb-3">
        <label>Email</label>
        <input type="email" name="email" value="{{ $fournisseur->email }}" class="form-control">
    </div>

    <div class="mb-3">
        <label>Adresse</label>
        <input type="text" name="adresse" value="{{ $fournisseur->adresse }}" class="form-control">
    </div>

    <button class="btn btn-primary">Modifier</button>
</form>

@endsection
