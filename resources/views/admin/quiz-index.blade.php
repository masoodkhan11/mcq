@extends('layout.admin')

@section('title', 'Quiz Report')
	
@section('content')

	<h1 class="page-title mb-4">Quiz Report</h1>

	<form action="{{ route('report.quiz.all') }}" method="get">
		<div class="row filter-report">
			<div class="col-md-3">
				<div class="form-group">
					<input type="text" class="form-control" name="user" value="{{ request()->user }}" placeholder="user name or email">
				</div>
			</div>
			<div class="col-md-3">
				<div class="form-group">
					<select name="status" class="custom-select">
						<option value="">Select Status</option>
						<option value="complete" {{ request()->status == 'complete' ? 'selected' : '' }}>Complete</option>
						<option value="incomplete" {{ request()->status == 'incomplete' ? 'selected' : '' }}>In-Complete</option>
					</select>
				</div>
			</div>
			<div class="col-md-4">
				<div class="input-group mb-3">
					<select name="sort_by" class="custom-select">
						<option value="">Sort By</option>
						<option value="scored_points" {{ request()->sort_by == 'scored_points' ? 'selected' : '' }}>Points</option>
						<option value="created_at" {{ request()->sort_by == 'created_at' ? 'selected' : '' }}>Date</option>
					</select>
					<div class="input-group-append">
						<select name="sort_order" class="custom-select">
							<option value="">Sort Order</option>
							<option value="DESC" {{ request()->sort_order == 'DESC' ? 'selected' : '' }}>DESC</option>
							<option value="ASC" {{ request()->sort_order == 'ASC' ? 'selected' : '' }}>ASC</option>
						</select>
					</div>
				</div>
			</div>
			<div class="col-md-2">
				<button type="submit" class="btn btn-primary">Filter</button>
				<a href="{{ route('report.quiz.all') }}" class="btn btn-danger">Reset</a>
			</div>
		</div>
	</form>

	<table class="table table-hover">
		<thead>
			<tr>
				<th scope="col">#</th>
				<th scope="col">User Name</th>
				<th scope="col">User Email</th>
				<th scope="col">Status</th>
				<th scope="col">Points</th>
				<th scope="col">Date</th>
				<th scope="col">Actions</th>
			</tr>
		</thead>
		<tbody>
			@foreach ($quizzesPlayed as $quizPlayed)
				<tr>
					<th scope="row">{{ $quizPlayed->id }}</th>
					<td>{{ $quizPlayed->user->name }}</td>
					<td>{{ $quizPlayed->user->email }}</td>
					<td>{!! $quizPlayed->getStatusHtml() !!}</td>
					<td>{{ $quizPlayed->scored_points }}</td>
					<td>{{ $quizPlayed->created_at }}</td>
					<td><a href="{{ route('report.quiz', $quizPlayed) }}" class="btn btn-sm btn-info">view</a></td>
				</tr>
			@endforeach
		</tbody>
	</table>

	<div class="pagination-wrapper mt-4">{{ $quizzesPlayed->appends(request()->all())->links() }}</div>
		

@endsection