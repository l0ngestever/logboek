@extends('layouts.application')

@section('content')

<h1>Taken</h1>

<p><a class="btn btn-primary btn-lg" href="{{ action('tasks.create') }}">Nieuwe taak</a></p>

	@if($tasks->count() == 0)
		<p>Er zijn <b>geen</b> taken gevonden!</p>
	@else

	@include('partials.modals')

	<table class="table table-hover">
		<tr>
			<th>ID</th>
			<th>Naam</th>
			<th>Eigenaar</th>
			<th>Deadline</th>
			<th>Status</th>
			<th>Beschrijving</th>
			<th>Voltooid</th>
		</tr>

		@foreach($tasks as $task)
		<tr data-id="{{ $task->id }}" data-status="{{ $task->isClosed() ? 'completed' : 'pending' }}" class="{{ $task->status ? 'success' : 'danger' }}">
			<td>{{ $task->id }}</td>
			<td>{{ link_to_action('tasks.show', $task->name, [$task->id]) }}</td>
			@if($task->user_id == 0)
				<td>systeem</td>
			@else
				<td> {{ link_to_action('users.show', $task->user->username, [$task->user->id]) }} </td>
			@endif
			<td>{{ $task->deadline }}</td>
			@if($task->status == 0)
				<td>Openstaand</td>
			@else
				<td>Afgesloten</td>
			@endif
			<td>
				<?php
					$modalBody;
					if($task->description == '') {
						$modalBody = 'Geen beschrijving gevonden.';
					} else {
						$modalBody = $task->description;
					}
				?>
				<button type="button" class="btn btn-primary btn-xs" data-toggle="modal" data-target="#myModal" data-title="{{ $task->name }}" data-content="{{ $modalBody; }}">Details</button>
			</td>
			<td><div class="btn-group btn-group-xs">
			<button type="button" data-default-class="btn-success" class="btn btn-default {{ $task->status ? 'btn-success' : '' }}">Ja</button>
			<button type="button" data-default-class="btn-danger" class="btn btn-default {{ $task->status ? '' : 'btn-danger' }}">Nee</button>
			</div></td>
		</tr>
		@endforeach

	</table>

	@endif

{{ $tasks->links() }}

@stop
