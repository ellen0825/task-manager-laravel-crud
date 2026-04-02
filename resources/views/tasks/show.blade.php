@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-7">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span>Task #{{ $task->id }}</span>
                @php
                    $badges = ['new' => 'secondary', 'in_progress' => 'warning text-dark', 'done' => 'success'];
                    $labels = ['new' => 'Новая', 'in_progress' => 'В процессе', 'done' => 'Завершённая'];
                @endphp
                <span class="badge bg-{{ $badges[$task->status] ?? 'secondary' }}">
                    {{ $labels[$task->status] ?? $task->status }}
                </span>
            </div>
            <div class="card-body">
                <h5 class="card-title">{{ $task->title }}</h5>
                <p class="card-text text-muted" style="white-space: pre-wrap">{{ $task->description ?: '—' }}</p>
                <hr>
                <small class="text-muted">
                    Создано: {{ $task->created_at->format('d.m.Y H:i') }} &nbsp;|&nbsp;
                    Обновлено: {{ $task->updated_at->format('d.m.Y H:i') }}
                </small>
            </div>
            <div class="card-footer d-flex gap-2">
                <a href="{{ route('tasks.edit', $task) }}" class="btn btn-warning btn-sm">Редактировать</a>
                <form action="{{ route('tasks.destroy', $task) }}" method="POST"
                      onsubmit="return confirm('Удалить эту задачу?')">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-danger btn-sm">Удалить</button>
                </form>
                <a href="{{ route('tasks.index') }}" class="btn btn-secondary btn-sm ms-auto">← К списку</a>
            </div>
        </div>
    </div>
</div>
@endsection
