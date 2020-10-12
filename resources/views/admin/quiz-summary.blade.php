@extends('layout.admin')

@section('title', 'Quiz Summary')
	
@section('content')

	<h1 class="page-title mb-4">Quiz Summary - #{{ $quizPlayed->id }}</h1>

	<div class="card">
		<div class="card-body">
			<h5 class="card-title">Date: {{ $quizPlayed->created_at }}</h5>
		</div>
		<ul class="list-group flex-row justify-content-between mb-1">
			<li class="list-group-item border-0">
				<span class="mr-1">User: <b>{{ $quizPlayed->user->name }}</b></span>
				<a href="{{ route('report.user', $quizPlayed->user) }}">view</a></li>
			<li class="list-group-item border-0">Status: {!! $quizPlayed->getStatusHtml() !!}</li>
			<li class="list-group-item border-0">points Scored: <b>{{ $quizPlayed->scored_points }}</b></li>
		</ul>
	</div>

	<div class="my-3"></div>
		
	@foreach ($quizPlayed->playSummary as $summary)
		<div class="card">
			<div class="card-body">
				<h5 class="card-title">{!! ($loop->index + 1) . ' - ' 
					. $summary->quiz->question !!}</h5>
				<div class="card-text">
					<div class="d-flex justify-content-between align-items-center">
						<span>Your Answer: {{ $summary->answer }}</span>
						<span>Status: {!! $summary->getStatusHtml() !!}</span>
					</div>
				</div>
			</div>
		</div>
	@endforeach
		
@endsection