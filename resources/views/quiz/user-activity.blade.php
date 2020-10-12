@extends('layout.app')

@section('title', 'Activity')
	
@section('content')

	<h1 class="page-title mb-4">Activity</h1>

	<div class="card">
		<div class="card-body">
			<h5 class="card-title">{{ $user->name }}</h5>
    		<h6 class="card-subtitle mb-2 text-muted">{{ $user->email }}</h6>
		</div>
		<ul class="list-group flex-row justify-content-between mb-1">
			<li class="list-group-item border-0">Total Played: {{ $user->quiz_played_count }}</li>
			<li class="list-group-item border-0">Avg Points: <b>{{ $user->avg_points }}</b></li>
		</ul>
	</div>

	<div class="my-3"></div>
	
	@foreach ($user->quizPlayed as $quizPlayed)
		<div class="card">
			<div class="card-body">
				<p class="card-text">
					<span class="mr-2">Date: {{ $quizPlayed->created_at }}</span>
					@if ($quizPlayed->status == 'complete')
						<a href="{{ route('quiz.result', $quizPlayed) }}" class="btn btn-sm btn-primary">View</a>
					@endif
				</p>
				<ul class="list-group flex-row justify-content-between mb-1">
					<li class="list-group-item border-0">Status: {!! $quizPlayed->getStatusHtml() !!}</li>
					<li class="list-group-item border-0">points Scored: <b>{{ $quizPlayed->scored_points }}</b></li>
				</ul>
			</div>
		</div>
	@endforeach
		
@endsection