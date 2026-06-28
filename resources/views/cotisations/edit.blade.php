@extends('layouts.app')
@section('title','Modifier cotisation')
@section('page-title','Modifier une cotisation')

@section('content')
<form method="POST" action="{{ route('cotisations.update', $cotisation) }}">
    @csrf
    @method('PUT')
    @include('cotisations._form')
</form>
@endsection
