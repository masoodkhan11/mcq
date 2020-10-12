@extends('layout.app')

@section('title', 'Questions')
	
@section('content')

	<h1 class="page-title mb-4">Questions</h1>

	<form action="{{ route('quiz.submit', $quizPlayed) }}" method="post">
		@csrf
		
		@foreach ($quiz as $question)
			<div class="card">
				<div class="card-body">
					<h5 class="card-title">{!! ($loop->index + 1) . ' - ' . $question->question !!}</h5>
					<div class="card-text">
						@php
							$answers = array_merge(
								[$question->correct_answer],
								$question->incorrect_answers
							);

							shuffle($answers);
						@endphp				
						@foreach ($answers as $key => $answer)
							<div class="form-check form-check-inline">
								<input class="form-check-input" type="radio" name="answers[{{ $question->id }}]" id="answer-{{ $key }}" value="{{ $answer }}">
								<label class="form-check-label" for="answer-{{ $key }}">{!! $answer !!}</label>
							</div>
						@endforeach
					</div>
				</div>
			</div>
		@endforeach
		<div class="card">
			<div class="card-body text-right">
				<button type="submit" class="btn btn-primary">Submit</button>
			</div>
		</div>
	</form>

@endsection