@extends('layouts.app')

@section('content')

<style>
    .task-card {
        border: none;
        border-radius: 12px;
        box-shadow: 0 2px 8px rgba(0,0,0,.07);
        transition: transform .15s ease, box-shadow .15s ease;
    }
    .task-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(0,0,0,.12);
    }
    .status-pill {
        font-size: .72rem;
        font-weight: 600;
        letter-spacing: .04em;
        padding: .3em .75em;
        border-radius: 50px;
        text-transform: uppercase;
    }
    .status-new        { background: #e9ecef; color: #495057; }
    .status-in_progress{ background: #fff3cd; color: #856404; }
    .status-done       { background: #d1e7dd; color: #0a5c36; }
    .filter-bar {
        background: #fff;
        border-radius: 12px;
        box-shadow: 0 2px 8px rgba(0,0,0,.06);
        padding: 1rem 1.25rem;
    }
    .page-header {
        background: linear-gradient(135deg, #0d6efd 0%, #6610f2 100%);
        border-radius: 16px;
        padding: 2rem 2rem 1.75rem;
        color: #fff;
        margin-bottom: 1.5rem;
    }
    .page-header h1 { font-weight: 700; font-size: 1.75rem; margin: 0; }
    .page-header p  { opacity: .85; margin: .25rem 0 0; font-size: .9rem; }
    .btn-new {
        background: rgba(255,255,255,.2);
        border: 2px solid rgba(255,255,255,.6);
        color: #fff;
        font-weight: 600;
        border-radius: 8px;
        padding: .5rem 1.25rem;
        transition: background .15s;
    }
    .btn-new:hover { background: rgba(255,255,255,.35); color: #fff; }
    .task-title { font-weight: 600; color: #212529; font-size: .95rem; }
    .task-desc  { color: #6c757d; font-size: .82rem; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 320px; }
    .task-date  { font-size: .8rem; color: #adb5bd; }
    .action-btn { border-radius: 6px; font-size: .78rem; padding: .3rem .65rem; font-weight: 500; }
    .empty-state { text-align: center; padding: 4rem 1rem; color: #adb5bd; }
    .empty-state svg { margin-bottom: 1rem; opacity: .4; }
</style>

{{-- Header --}}
<div class="page-header d-flex justify-content-between align-items-center flex-wrap gap-3">
    <div>
        <h1>📋 Task Manager</h1>
        <p>{{ $tasks->total() }} {{ $tasks->total() === 1 ? 'задача' : ($tasks->total() < 5 ? 'задачи' : 'задач') }} всего</p>
    </div>
    <a href="{{ route('tasks.create') }}" class="btn btn-new">+ New Task</a>
</div>

{{-- Filter bar --}}
<div class="filter-bar mb-4">
    <form method="GET" action="{{ route('tasks.index') }}" class="row g-2 align-items-center">
        <div class="col-sm-5">
            <div class="input-group">
                <span class="input-group-text bg-white border-end-0">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor" viewBox="0 0 16 16">
                        <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398l3.85 3.85a1 1 0 0 0 1.415-1.415l-3.868-3.833zm-5.242 1.156a5.5 5.5 0 1 1 0-11 5.5 5.5 0 0 1 0 11z"/>
                    </svg>
                </span>
                <input type="text" name="search" class="form-control border-start-0 ps-0"
                       placeholder="Поиск по названию…" value="{{ request('search') }}">
            </div>
        </div>
        <div class="col-sm-3">
            <select name="status" class="form-select">
                <option value="">Все статусы</option>
                <option value="new"         {{ request('status') === 'new'         ? 'selected' : '' }}>Новая</option>
                <option value="in_progress" {{ request('status') === 'in_progress' ? 'selected' : '' }}>В процессе</option>
                <option value="done"        {{ request('status') === 'done'        ? 'selected' : '' }}>Завершённая</option>
            </select>
        </div>
        <div class="col-sm-auto d-flex gap-2">
            <button type="submit" class="btn btn-primary">Фильтр</button>
            @if(request('search') || request('status'))
                <a href="{{ route('tasks.index') }}" class="btn btn-outline-secondary">✕ Сбросить</a>
            @endif
        </div>
    </form>
</div>

{{-- Task list --}}
@if($tasks->isEmpty())
    <div class="empty-state">
        <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" fill="currentColor" viewBox="0 0 16 16">
            <path d="M5 10.5a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5zm0-2a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5zm0-2a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5zm0-2a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5z"/>
            <path d="M3 0h10a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V2a2 2 0 0 1 2-2zm0 1a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h10a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H3z"/>
        </svg>
        <p class="fs-5 fw-semibold">Задачи не найдены</p>
        <p class="small">Попробуйте изменить фильтры или <a href="{{ route('tasks.create') }}">создайте новую задачу</a>.</p>
    </div>
@else
    <div class="d-flex flex-column gap-3">
        @foreach($tasks as $task)
        @php
            $statusClass = 'status-' . $task->status;
            $labels = ['new' => 'Новая', 'in_progress' => 'В процессе', 'done' => 'Завершённая'];
        @endphp
        <div class="card task-card">
            <div class="card-body d-flex align-items-center gap-3 flex-wrap">

                {{-- Status indicator --}}
                <div class="flex-shrink-0">
                    <span class="status-pill {{ $statusClass }}">{{ $labels[$task->status] ?? $task->status }}</span>
                </div>

                {{-- Title + description --}}
                <div class="flex-grow-1" style="min-width: 0">
                    <div class="task-title">{{ $task->title }}</div>
                    @if($task->description)
                        <div class="task-desc">{{ $task->description }}</div>
                    @endif
                </div>

                {{-- Date --}}
                <div class="task-date flex-shrink-0 d-none d-md-block">
                    {{ $task->created_at->format('d M Y') }}
                </div>

                {{-- Actions --}}
                <div class="d-flex gap-1 flex-shrink-0">
                    <a href="{{ route('tasks.show', $task) }}" class="btn btn-sm btn-outline-primary action-btn">Просмотр</a>
                    <a href="{{ route('tasks.edit', $task) }}" class="btn btn-sm btn-outline-warning action-btn">Изменить</a>
                    <form action="{{ route('tasks.destroy', $task) }}" method="POST"
                          onsubmit="return confirm('Удалить эту задачу?')">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-sm btn-outline-danger action-btn">Удалить</button>
                    </form>
                </div>

            </div>
        </div>
        @endforeach
    </div>

    <div class="mt-4">
        {{ $tasks->withQueryString()->links() }}
    </div>
@endif

@endsection
