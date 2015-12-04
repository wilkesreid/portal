@extends('layouts.main')

@section('title')
Home
@stop

@section('body')
<h1>Home</h1>
@if ( Auth::check() )
<p>Welcome, <u>{{ Auth::user()->name }}</u>!</p>
@if ( Auth::user()->role() == "pending" )
<p>Your account is pending. You won't be able to do anything on the site until an administrator approves your account.</p>
@endif
@else
<p>You are not logged in.</p>
@endif
@stop