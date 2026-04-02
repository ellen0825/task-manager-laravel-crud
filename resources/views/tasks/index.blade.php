@extends('layouts.app')

@section('content')
@php
    $statusMap = [
        'new'         => ['pill' => 's-new',  'label' => 'Новая'],
        'in_progress' => ['pill' => 's-wip',  'label' => 'В процессе'],
        'done'        => ['pill' => 's-done', 'label' => 'Завершённая'],
    ];
@endphp

{{-- Page header --}}
<div class="d-flex align-items-start justify-content-between mb-4 flex-wrap gap-3">
    <div>
        <div class="page-title">Мои задачи</div>
        <div class="page-sub">
            @php
                $t = $tasks->total();
                $word = $t === 1 ? 'задача' : ($t < 5 ? 'задачи' : 'задач');
            @endphp
            {{ $t }} {{ $word }} найдено
        </div>
    </div>

    {{-- Status counters --}}
    <div class="d-flex gap-2 flex-wrap">
        @foreach(['new' => 'Новая', 'in_progress' => 'В процессе', 'done' => 'Завершённая'] as $s => $l)
        <a href="{{ route('tasks.index', ['status' => $s] + (request('search') ? ['search' => request('search')] : [])) }}"
           class="s-pill {{ $statusMap[$s]['pill'] }}"
           style="text-decoration:none; {{ request('status') === $s ? 'outline:2px solid currentColor;outline-offset:2px;' : '' }}">
            {{ $l }}
        </a>
        @endforeach
    </div>
</div>

{{-- Filter bar --}}
<div class="glass p-3 mb-4">
    <form method="GET" action="{{ route('tasks.index') }}" class="d-flex gap-2 flex-wrap align-items-center">
        <div class="flex-grow-1" style="min-width:200px; position:relative">
            <svg style="position:absolute;left:.85rem;top:50%;transform:translateY(-50%);opacity:.4" xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor" viewBox="0 0 16 16">
                <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398l3.85 3.85a1 1 0 0 0 1.415-1.415l-3.868-3.833zm-5.242 1.156a5.5 5.5 0 1 1 0-11 5.5 5.5 0 0 1 0 11z"/>
            </svg>
            <input type="text" name="search" class="form-control" style="padding-left:2.4rem"
                   placeholder="Поиск по названию…" value="{{ request('search') }}">
        </div>
        <select name="status" class="form-select" style="max-width:180px">
            <option value="">Все статусы</option>
            <option value="new"         {{ request('status') === 'new'         ? 'selected' : '' }}>Новая</option>
            <option value="in_progress" {{ request('status') === 'in_progress' ? 'selected' : '' }}>В процессе</option>
            <option value="done"        {{ request('status') === 'done'        ? 'selected' : '' }}>Завершённая</option>
        </select>
        <button type="submit" class="btn-accent btn" style="font-size:.85rem">Найти</button>
        @if(request('search') || request('status'))
            <a href="{{ route('tasks.index') }}" class="btn-ghost btn" style="font-size:.85rem">✕ Сброс</a>
        @endif
    </form>
</div>

{{-- Task list --}}
@if($tasks->isEmpty())
<div class="glass text-center py-5 px-3">
    <div style="font-size:3rem;margin-bottom:.75rem;opacity:.3">📭</div>
    <div style="font-weight:600;font-size:1.05rem;margin-bottom:.4rem">Задачи не найдены</div>
    <div class="text-muted" style="font-size:.88rem">Попробуйте изменить фильтры или
        <a href="{{ route('tasks.create') }}" style="color:var(--accent2);text-decoration:none">создайте новую задачу</a>.
    </div>
</div>
@else
<div class="d-flex flex-column gap-2">
    @foreach($tasks as $task)
    @php $sm = $statusMap[$task->status] ?? ['pill'=>'s-new','label'=>$task->status]; @endphp
    <div class="glass task-row" style="padding:1rem 1.25rem; transition: border-color .15s;"
         onmouseover="this.style.borderColor='rgba(255,255,255,.14)'"
         onmouseout="this.style.borderColor='rgba(255,255,255,.07)'">
        <div class="d-flex align-items-center gap-3 flex-wrap">

            {{-- Status pill --}}
            <span class="s-pill {{ $sm['pill'] }}" style="flex-shrink:0">{{ $sm['label'] }}</span>

            {{-- Title + desc --}}
            <div style="flex:1; min-width:0">
                <a href="{{ route('tasks.show', $task) }}"
                   style="font-weight:600; font-size:.95rem; text-decoration:none; color:var(--text)"
                   onmouseover="this.style.color='var(--accent2)'"
                   onmouseout="this.style.color='var(--text)'">
                    {{ $task->title }}
                </a>
                @if($task->description)
                <div style="font-size:.8rem; color:var(--muted); white-space:nowrap; overflow:hidden; text-overflow:ellipsis; max-width:420px; margin-top:.15rem">
                    {{ $task->description }}
                </div>
                @endif
            </div>

            {{-- Date --}}
            <div style="font-size:.78rem; color:var(--muted); flex-shrink:0" class="d-none d-md-block">
                {{ $task->created_at->format('d M Y') }}
            </div>

            {{-- Actions --}}
            <div class="d-flex gap-1 flex-shrink-0">
                <a href="{{ route('tasks.show', $task) }}" class="btn-icon view">Просмотр</a>
                <a href="{{ route('tasks.edit', $task) }}" class="btn-icon edit">Изменить</a>
                <form action="{{ route('tasks.destroy', $task) }}" method="POST"
                      onsubmit="return confirm('Удалить эту задачу?')">
                    @csrf @method('DELETE')
                    <button class="btn-icon del">Удалить</button>
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
