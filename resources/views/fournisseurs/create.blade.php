@extends('layouts.app')

@section('content')

<h2>Ajouter Fournisseur</h2>

<form method="POST" action="{{ route('fournisseurs.store') }}">
    @csrf

    <div class="mb-3">
        <label>Nom</label>
        <input type="text" name="nom" class="form-control">
    </div>

    <div class="mb-3">
        <label>Téléphone</label>
        <input type="text" name="telephone" class="form-control">
    </div>

    <div class="mb-3">
        <label>Email</label>
        <input type="email" name="email" class="form-control">
    </div>

    <div class="mb-3">
        <label>Adresse</label>
        <input type="text" name="adresse" class="form-control">
    </div>

    <button class="btn btn-success">Enregistrer</button>
</form>

@endsection
