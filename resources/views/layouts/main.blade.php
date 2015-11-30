<!DOCTYPE html>
<html ng-app="app">
<head>
	
<title>
@yield('title')
</title>

@section('head')

@if ( Auth::check() )
<link rel="stylesheet" href="{{ Auth::user()->theme->style_url }}">
@else
<link rel="stylesheet" href="{{ asset('css/themes/cosmo/bootstrap.min.css') }}">
@endif

@show
</head>

<body>
	
@include('nav')

<div class="container" id="layout_body">
@yield('body')
</div>

<script src="/js/lib/angular.min.js"></script>
<script src="/js/lib/ui-bootstrap-tpls-0.14.3.min.js"></script>
<script src="/js/angular/app.js"></script>
<script src="/js/angular/navbar.js"></script>

</body>

</html>