@extends('layouts.master')

@section('content')
    @if (auth()->user())
        <film :slug="'{{ $slug }}'" :user="{{ auth()->user() }}"></film>
    @else
        <film :slug="'{{ $slug }}'"></film>
    @endif
@endsection
