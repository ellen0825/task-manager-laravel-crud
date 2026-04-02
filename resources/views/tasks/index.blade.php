@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h1 class="h3">Tasks</h1>
    <a href="{{ route('tasks.create') }}" class="btn btn-primary">+ New Task</a>
</div>

<form method="GET" action="{{ route('tasks.index') }}" class="row g-2 mb-4">
    <div class="col-sm-6">
        <input type="text" name="search" class="form-control" placeholder="Search by title..." value="{{ request('search') }}">
    </div>
    <div class="col-sm-3">
        <select name="status" class="form-select">
            <option value="">All statuses</option>
            <option value="new"         {{ request('status') === 'new'         ? 'selected' : '' }}>New</option>
            <option value="in_progress" {{ request('status') === 'in_progress' ? 'selected' : '' }}>In Progress</option>
            <option value="done"        {{ request('status') === 'done'        ? 'selected' : '' }}>Done</option>
        </select>
    </div>
    <div class="col-sm-auto">
        <button type="submit" class="btn btn-secondary">Filter</button>
        <a href="{{ route('tasks.index') }}" class="btn btn-outline-secondary">Reset</a>
    </div>
</form>

@if($tasks->isEmpty())
    <p class="text-muted">No tasks found.</p>
@else
<table class="table table-bordered table-hover bg-white">
    <thead class="table-dark">
        <tr>
            <th>#</th>
            <th>Title</th>
            <th>Status</th>
            <th>Created</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach($tasks as $task)
        <tr>
            <td>{{ $task->id }}</td>
            <td>{{ $task->title }}</td>
            <td>
                @php
                    $badges = ['new' => 'secondary', 'in_progress' => 'warning text-dark', 'done' => 'success'];
                    $labels = ['new' => 'New', 'in_progress' => 'In Progress', 'done' => 'Done'];
                @endphp
                <span class="badge bg-{{ $badges[$task->status] ?? 'secondary' }}">
                    {{ $labels[$task->status] ?? $task->status }}
                </span>
            </td>
            <td>{{ $task->created_at->format('d.m.Y') }}</td>
            <td>
                <a href="{{ route('tasks.show', $task) }}" class="btn btn-sm btn-info text-white">View</a>
                <a href="{{ route('tasks.edit', $task) }}" class="btn btn-sm btn-warning">Edit</a>
                <form action="{{ route('tasks.destroy', $task) }}" method="POST" class="d-inline"
                      onsubmit="return confirm('Delete this task?')">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-sm btn-danger">Delete</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

{{ $tasks->withQueryString()->links() }}
@endif
@endsection
