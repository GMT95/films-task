@extends('layouts.master')

@section('scripts')
<link rel="stylesheet" href="https://unpkg.com/vue-multiselect@2.1.6/dist/vue-multiselect.min.css">
@endsection

@section('content')
    <create-film :genres="{{$genres}}"></create-film>
@endsection
