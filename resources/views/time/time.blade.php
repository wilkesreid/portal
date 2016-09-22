@extends('layouts.main')

@section('title')
Portal - Time
@stop

@section('body')

<h1>My Time</h1>
<p>Current Pay Period: {{ $prev_pay_period_day->toFormattedDateString() }} - {{ $next_pay_period_day->toFormattedDateString() }}</p>

@stop