@extends('layout.admin')

@section('title', 'Users Report')
	
@section('content')

	<h1 class="page-title mb-4">Users Report</h1>

	<form action="{{ route('report.users') }}" method="get">
		<div class="row filter-report">
			<div class="col-md-3">
				<div class="form-group">
					<input type="text" class="form-control" name="name" value="{{ request()->name }}" placeholder="user name">
				</div>
			</div>
			<div class="col-md-3">
				<div class="form-group">
					<input type="text" class="form-control" name="email" value="{{ request()->email }}" placeholder="user email">
				</div>
			</div>
			<div class="col-md-4">
				<div class="input-group mb-3">
					<select name="sort_by" class="custom-select">
						<option value="">Sort By</option>
						<option value="quiz_played_count" {{ request()->sort_by == 'quiz_played_count' ? 'selected' : '' }}>Quiz Played</option>
						<option value="avg_points" {{ request()->sort_by == 'avg_points' ? 'selected' : '' }}>Avg Points</option>
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
				<a href="{{ route('report.users') }}" class="btn btn-danger">Reset</a>
			</div>
		</div>
	</form>

	<table class="table table-hover">
		<thead>
			<tr>
				<th scope="col">#</th>
				<th scope="col">Name</th>
				<th scope="col">Email</th>
				<th scope="col">Quiz Played</th>
				<th scope="col">Avg Points</th>
				<th scope="col">Actions</th>
			</tr>
		</thead>
		<tbody>
			@foreach ($users as $user)
				<tr>
					<th scope="row">{{ $user->id }}</th>
					<td>{{ $user->name }}</td>
					<td>{{ $user->email }}</td>
					<td>{{ $user->quiz_played_count }}</td>
					<td>{{ $user->avg_points }}</td>
					<td><a href="{{ route('report.user', $user) }}" class="btn btn-sm btn-info">view</a></td>
				</tr>
			@endforeach
		</tbody>
	</table>

	<div class="pagination-wrapper mt-4">{{ $users->appends(request()->all())->links() }}</div>
		

@endsection