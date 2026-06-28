@extends('layouts.app')
@section('title','Nouvelle cotisation')
@section('page-title','Enregistrer une cotisation')

@section('content')
<form method="POST" action="{{ route('cotisations.store') }}">
    @csrf
    @include('cotisations._form')
</form>
@endsection
