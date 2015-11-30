<nav class="navbar navbar-default" role="navigation" ng-controller="NavbarController as nav">
	<div class="container-fluid">
		<div class="navbar-header">
        <button type="button" class="navbar-toggle" ng-click="nav.collapsed = !nav.collapsed">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="/">Portal</a>
		</div>
		<div class="collapse navbar-collapse nav-collapse navbar-responsive-collapse" id="navbar-collapse" uib-collapse="nav.collapsed">
			<ul class="nav navbar-nav">				
				
				<li class="{{ Request::is('/') ? 'active' : '' }}"><a href="/">Home</a></li>
				
				@if ( Auth::check() )
				<li class="{{ Request::is('time') ? 'active' : '' }}"><a href="/time">Time Tracking</a></li>
				@endif
				
			</ul>
			<ul class="nav navbar-nav navbar-right">
				@if ( !Auth::check() )
				<li class="{{ Request::is('auth/login') ? 'active' : '' }}"><a href="/auth/login">Login</a></li>
				@else
				<li class="dropdown" uib-dropdown>
					<a class="dropdown-toggle" data-toggle="dropdown" uib-dropdown-toggle role="button" aria-haspopup="true">
						Profile <span class="caret"></span>
					</a>
					<ul class="dropdown-menu">
						<li><a href="/user/settings"><span class="glyphicon glyphicon-cog"></span> Settings</a></li>
						<li><a href="/auth/logout"><span class="glyphicon glyphicon-log-out"></span> Logout</a></li>
					</ul>
				</li>
				@endif
			</ul>
		</div> <!-- /.navbar-collapse -->
	</div> <!-- /.container-fluid -->
</nav>