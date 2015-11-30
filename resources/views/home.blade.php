@extends('layouts.main')

@section('title')
Home
@stop

@section('body')
<h1>Home</h1>
@if ( Auth::check() )
<p>Welcome, <u>{{ Auth::user()->name }}</u>!</p>
@else
<p>You are not logged in.</p>
@endif
@stop