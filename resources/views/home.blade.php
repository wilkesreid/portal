@extends('layouts.main')

@section('title')
Portal - Home
@stop

@section('body')
@if ( Auth::check() )

<div class="homepage-buttons">
	<a href="/clients">Client Passwords</a>
	<a href="/clients/26">Internal Passwords</a>
	<a href="/milestones">Milestones</a>
	<a href="/auditforms">Audit Forms</a>
	<a href="/websites">Check Websites</a>
	<a href="/user/security">Enter Encryption Key</a>
</div>

@if ( Auth::user()->role() == "pending" )
<p>Your account is pending. You won't be able to do anything on the site until an administrator approves your account.</p>
@endif
@else
<div class="homepage-buttons">
    <a href="/auth/login">Log In</a>
    <a href="/auth/register">Register</a>
</div>
@endif
@stop