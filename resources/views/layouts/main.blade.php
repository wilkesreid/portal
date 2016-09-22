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
<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/themes/smoothness/jquery-ui.css">
<link href='https://fonts.googleapis.com/css?family=Roboto:400,300,100' rel='stylesheet' type='text/css'>
<link rel="stylesheet" href="/css/custom.css">
<link rel="stylesheet" href="/css/font-awesome.min.css">
@stack('styles')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
<script src="/js/lib/angular.min.js"></script>
<script src="/js/lib/ui-bootstrap-tpls-0.14.3.min.js"></script>
<script src="/js/lib/checklist-model.js"></script>
<script src="/js/lib/clipboard.min.js"></script>
<script src="/js/lib/ngclipboard.min.js"></script>
<script src="/js/lib/underscore.js"></script>
<script src="/js/lib/md5.js"></script>
<script src="/js/lib/elastic.js"></script>
<script src="/js/lib/slider.js"></script>
<script src="/js/lib/contextMenu.js"></script>
<script src="/js/lib/ng-file-upload.min.js"></script>
<script src="https://cdn.pubnub.com/pubnub-dev.js"></script>
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