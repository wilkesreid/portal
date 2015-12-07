<!DOCTYPE html>
<html ng-app="app">
<head>
	
<title>
@yield('title')
</title>

@section('head')
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
@if ( Auth::check() )
<link rel="stylesheet" href="{{ Auth::user()->theme()->style_url }}">
@else
<link rel="stylesheet" href="{{ App\Theme::find(App\Setting::getValue('guest_theme'))->style_url }}">
@endif
<link rel="stylesheet" href="/css/custom.css">
<link rel="stylesheet" href="/css/font-awesome.min.css">

<script src="/js/lib/angular.min.js"></script>
<script src="/js/lib/ui-bootstrap-tpls-0.14.3.min.js"></script>
<script src="/js/lib/clipboard.min.js"></script>
<script src="/js/lib/ngclipboard.min.js"></script>
<script src="/js/angular/app.js"></script>
<script src="/js/angular/navbar.js"></script>

@show
</head>

<body>
	
@include('nav')

<div class="container" id="layout_body">
@yield('body')
</div>
</body>

</html>