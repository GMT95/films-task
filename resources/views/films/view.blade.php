@extends('layouts.master')

@section('content')
    <film :slug="'{{$slug}}'"></film>
@endsection
