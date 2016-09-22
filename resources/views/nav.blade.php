<?php
  $user = Auth::user();
?>
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
					@can('view-passwords')
				<li class="dropdown {{ Request::is('clients') ? 'active' : ''}}" uib-dropdown>
					<a class="dropdown-toggle" data-toggle="dropdown" uib-dropdown-toggle role="button" aria-haspopup="true">
						Password Manager <span class="caret"></span>
					</a>
		          <ul class="dropdown-menu" role="menu">
			        <li><a href="/clients">Clients</a></li>
		            <li><a href="/clients/26">Internal</a></li>
		          </ul>
		        </li>
				<!--<li class="{{ Request::is('time') ? 'active' : '' }}"><a href="/time">Time Tracking</a></li>-->
					@endcan
					@can ('view-websites')
				<li class="{{ Request::is('websites') ? 'active' : '' }}"><a href="/websites">Websites</a></li>
					@endcan
				<li class="{{ Request::is('milestones') ? 'active' : '' }}"><a href="/milestones">Milestones</a></li>
				<li class="{{ Request::is('auditforms') ? 'active' : '' }}"><a href="/auditforms">Forms</a></li>
				<li class="dropdown {{ Request::is('clients') ? 'active' : ''}}" uib-dropdown>
					<a class="dropdown-toggle" data-toggle="dropdown" uib-dropdown-toggle role="button" aria-haspopup="true">
						Old <span class="caret"></span>
					</a>
          <ul class="dropdown-menu" role="menu">
            <li class="{{ Request::is('forms') ? 'active' : '' }}"><a href="/forms">Forms</a></li>
          </ul>
        </li>
				@endif
			</ul>
			<ul class="nav navbar-nav navbar-right">
				@if ( !Auth::check() )
				<li class="{{ Request::is('auth/login') ? 'active' : '' }}"><a href="/auth/login">Log In</a></li>
				@else
				@can('update-admin-settings')
				<li class="dropdown" uib-dropdown>
					<a class="dropdown-toggle" data-toggle="dropdown" uib-dropdown-toggle role="button" aria-haspopup="true">
						Admin <span class="caret"></span>
					</a>
					<ul class="dropdown-menu">
						<li><a href="/admin/roles"><span class="fa fa-unlock"></span> Roles</a></li>
						<li><a href="/admin/security"><span class="fa fa-shield"></span> Security</a></li>
						<li><a href="/admin/users"><span class="fa fa-users"></span> Users</a></li>
						<li><a href="/admin/settings"><span class="fa fa-cog"></span> Settings</a></li>
					</ul>
				</li>
				@endcan
				@can('use-tools-menu')
				<li class="dropdown" uib-dropdown>
				  <a class="dropdown-toggle" data-toggle="dropdown" uib-dropdown-toggle role="button" aria-haspopup="true">
						Edit <span class="caret"></span>
					</a>
					<ul class="dropdown-menu">
  					@can('edit-tactics')
						<li><a href="/admin/tactictypes"><span class="fa fa-wrench"></span> Tactics</a></li>
						@endcan
					</ul>
				</li>
				@endcan
				<li class="dropdown" uib-dropdown>
					<a class="dropdown-toggle" data-toggle="dropdown" uib-dropdown-toggle role="button" aria-haspopup="true">
						{{ $user->name }} <span class="caret"></span>
					</a>
					<ul class="dropdown-menu">
						@can('security-menu')
						<li><a href="/user/security"><span class="fa fa-shield"></span> Security</a></li>
						@endcan
						<li><a href="/user/settings"><span class="fa fa-cog"></span> Settings</a></li>
						<li><a href="/auth/logout"><span class="fa fa-sign-out"></span> Logout</a></li>
					</ul>
				</li>
				@endif
			</ul>
		</div> <!-- /.navbar-collapse -->
	</div> <!-- /.container-fluid -->
</nav>