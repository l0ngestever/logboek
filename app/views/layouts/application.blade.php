<!DOCTYPE html>
<html lang="{{ Lang::locale() }}">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="shortcut icon" href="/favicon.ico">

	<title>{{ Setting::get('project_name') }}</title>

	<!-- Bootstrap core CSS -->
	<link href="/css/bootstrap.min.css" rel="stylesheet">

	<!-- Custom styles for this template -->
	<link href="/css/offcanvas.css" rel="stylesheet">

	<link href="/css/application.css" rel="stylesheet">

	<link href="/css/cipher.css" rel="stylesheet">

	<link rel="stylesheet" href="/css/dropzone.css" media="all">

	<link href="/css/bootstrap-markdown.min.css" rel="stylesheet">

	<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
	<!--[if lt IE 9]>
	<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
	<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
	<![endif]-->
	</head>

	<body>
		<div class="navbar navbar-fixed-top navbar-inverse" role="navigation">
			<div class="container">
				<div class="navbar-header">
					<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
						<span class="sr-only">Toggle navigation</span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
					<a class="navbar-brand" href="/">{{ Setting::get('project_name') }}</a>
				</div>
				<div class="collapse navbar-collapse">

					<ul class="nav navbar-nav">
						@if(Setting::contains('menu', 'entries'))
							<li {{ Request::is('entries') || Request::is('/') ? 'class="active"' : '' }}>{{ link_to('/entries', 'Entries') }}</li>
						@endif
						@if(Setting::contains('menu', 'logbooks'))
							<li {{ Request::is('logbooks') ? 'class="active"' : '' }}>{{ link_to_route('logbooks.index', 'Logboeken') }}</li>
						@endif
						@if(Setting::contains('menu', 'tasks'))
							<li {{ Request::is('tasks') ? 'class="active"' : '' }}>{{ link_to_route('tasks.index', 'Taken') }}</li>
						@endif

						@if(Setting::contains('menu', 'attachments'))
							<li {{ Request::is('attachments') ? 'class="active"' : '' }}>{{ link_to_route('attachments.index', 'Bestanden') }}</li>
						@endif
						@if(Setting::contains('menu', 'evidences'))
							<li {{ Request::is('evidences') ? 'class="active"' : '' }}>{{ link_to_route('evidences.index', 'Bewijzen') }}</li>
						@endif
						@if(Setting::contains('menu', 'exports'))
							<li {{ Request::is('exports') ? 'class="active"' : '' }}>{{ link_to_action('ExportsController@index', 'Exports') }}</li>
						@endif
						@if(Setting::contains('menu', 'cipher'))
							<li {{ Request::is('cipher') ? 'class="active"' : '' }}>{{ link_to('/cipher', 'Ciphertool') }}</li>
						@endif

						@if(Setting::contains('menu', 'tools'))
							<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown">Tools <b class="caret"></b></a>
								<ul class="dropdown-menu" role="menu">
									<li>{{ link_to('/cipher', 'Ciphertool') }}</li>
									<li class="divider"></li>
									<li>{{ link_to_route('legals.index', 'Juridishe kader') }}</li>
								</ul>
							</li>
						@endif

						<li {{ Request::is('settings') ? 'class="active"' : '' }}>{{ link_to_route('settings.index', 'Instellingen') }}</li>
						<li {{ Request::is('intro') ? 'class="active"' : '' }}>{{ link_to('/intro', 'Over') }}</li>
					</ul>

					@if(Auth::check())
					<ul class="nav navbar-nav navbar-right">
						<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">Hallo, {{ Auth::user()->username }} <b class="caret"></b></a>
							<ul class="dropdown-menu" role="menu">
								<li>{{ link_to_route('users.edit', 'Profiel bewerken', array(Auth::user()->id)) }}</li>
								<li class="divider"></li>
								<li>{{ link_to('/logout', 'Uitloggen') }}</li>
							</ul>
						</li>
					</ul>
					@endif

			</div><!-- /.nav-collapse -->
		</div><!-- /.container -->
	</div><!-- /.navbar -->

<div class="container">
	<div class="row row-offcanvas row-offcanvas-right">

		<div class="col-xs-12 col-sm-9">
			<p class="pull-right visible-xs">
				<button type="button" class="btn btn-primary btn-xs" data-toggle="offcanvas">Toggle nav</button>
			</p>

			@include('partials.alert')

			@yield('content')
		</div><!--/span-->

		<div class="col-xs-6 col-sm-3 sidebar-offcanvas" id="sidebar" role="navigation">

			@section('sidebar')

			<h3>Logboeken</h3>
			@if(count($logbooks_visible) === 0)
				<p><div style="align:left;">Geen logboeken gevonden.</div></p>
			@else
			<div class="list-group">
				@foreach($logbooks_visible as $logbook)
				{{ link_to_action('logbooks.show', $logbook->title, [$logbook->id], [
				'class' => 'list-group-item '.(Request::is('logbooks/'.$logbook->id, 'logbooks/'.$logbook->id.'/*') ? 'active' : '')
				]) }}
				@endforeach
			</div>
			@endif

			@if(isset($user_logbook))
			<p>
			<a class="btn btn-primary btn-lg" href="{{ action('logbooks.entries.create', [$user_logbook->id]) }}">Schrijf in je logboek</a>
			</p>
			@endif

	  <h3>Recente taken</h3>

	  @if(count($recent_tasks) === 0)
		  <p><div style="align:left;">Geen openstaande taken gevonden.</div></p>
	  @else
		  <div class="list-group">
			@foreach($recent_tasks as $task)
	          	{{ link_to_action('tasks.show', $task->name, [$task->id], [
        	          	'class' =>  'list-group-item '.(Request::is('tasks/'.$task->id.'*') ? 'active' : '')
          		]) }}
	          	@endforeach
		  </div>
	  @endif
		@show

	</div><!--/span-->
</div><!--/row-->

<hr>

<footer class="muted">
	<p class="pull-left">&copy; 2014 <a href="http://duckson.nl">Mathijs Bernson</a>, <a href="http://bartmauritz.nl">Bart Mauritz</a></p>
	<p class="pull-right"><a href="https://github.com/l0ngestever/logboek/">Source</a> | <a href="https://github.com/l0ngestever/logboek/blob/master/LICENSE.txt">GPL License</a></p>
</footer>

</div><!--/.container-->

<!-- Bootstrap core JavaScript -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="/js/bootstrap.min.js"></script>
<script src="/js/offcanvas.js"></script>
<script src="/js/entry.js"></script>
<script src="/js/tasks.js"></script>
<script src="/js/dropzone.js"></script>
<script src="/js/attachments.js"></script>
<script src="/js/signature_pad.js"></script>
<script src="/js/signature_pad_app.js"></script>

<!-- Following 4 lines are supported for markdown WYSIWYG editor! -->
<script src="/js/bootstrap-markdown.js"></script>
<script src="/js/bootstrap-markdown.nl.js"></script>
<script src="/js/markdown.js"></script>
<script src="/js/to-markdown.js"></script>

<!-- Dutch language support WYSIWYG -->
<script type="text/javascript">
	$("#markdown-lang").markdown({language:'nl'})
</script>

<!-- Model popup code, loading after jQuery -->
<script type="text/javascript">
	$(document).ready(function(){
		$("#myModal").on('show.bs.modal', function(event){
					var button = $(event.relatedTarget);  // Button that triggered the modal
					var titleData = button.data('title'); // Extract value from data-* attributes
					var bodyData = button.data('content');
					var bodyData2 = button.data('content2');
					var urlData = button.data('url'); // Extract value from data-* attributes
					$(this).find('.modal-title').text(titleData);
					$(this).find('.modal-body').text(bodyData);
					$(this).find('.modal-body2').text(bodyData2);
					$(this).find('.modal-url').text(urlData);
			});
	});
</script>

@if(App::environment('production') && Config::get('app.piwik_enabled') == true)

{{-- This must be on one line, otherwise blade will not parse it --}}
@include('partials.piwik_tag', ['tracker_url' => Config::get('app.piwik_tracker_url'), 'site_id' => Config::get('app.piwik_site_id')])

@endif

</body>
</html>
