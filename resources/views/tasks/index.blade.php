<!DOCTYPE html>
<html>
<head>
    <title>Task Manager</title>
</head>
<body>

<h1>Task List</h1>

<form method="GET" action="{{ route('tasks.index') }}">
    <input type="text" name="search" placeholder="Search..." value="{{ request('search') }}">

    <select name="status">
        <option value="">All</option>
        <option value="new" {{ request('status') == 'new' ? 'selected' : '' }}>New</option>
        <option value="in_progress" {{ request('status') == 'in_progress' ? 'selected' : '' }}>In Progress</option>
        <option value="done" {{ request('status') == 'done' ? 'selected' : '' }}>Done</option>
    </select>

    <button type="submit">Filter</button>
</form>

<br>

<a href="{{ route('tasks.create') }}">Create New Task</a>

<br><br>
<table border="1" cellpadding="10">
    <tr>
        <th>ID</th>
        <th>Title</th>
        <th>Status</th>
        <th>Actions</th>
    </tr>

    @foreach($tasks as $task)
    <tr>
        <td>{{ $task->id }}</td>
        <td>{{ $task->title }}</td>
        <td>{{ $task->status }}</td>
        <td>
            <a href="{{ route('tasks.show', $task->id) }}">View</a>
            <a href="{{ route('tasks.edit', $task->id) }}">Edit</a>

            <form action="{{ route('tasks.destroy', $task->id) }}" method="POST" style="display:inline;">
                @csrf
                @method('DELETE')
                <button type="submit">Delete</button>
            </form>
        </td>
    </tr>
    @endforeach

</table>

<br>

{{ $tasks->links() }}

</body>
</html>