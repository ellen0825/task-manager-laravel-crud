@extends('layouts.app')

@section('content')
@php
    $statusMap = [
        'new'         => ['pill' => 's-new',  'label' => 'Новая'],
        'in_progress' => ['pill' => 's-wip',  'label' => 'В процессе'],
        'done'        => ['pill' => 's-done', 'label' => 'Завершённая'],
    ];
    $sm = $statusMap[$task->status] ?? ['pill' => 's-new', 'label' => $task->status];
@endphp

<div class="mb-4">
    <a href="{{ route('tasks.index') }}" style="color:var(--muted); text-decoration:none; font-size:.85rem; display:inline-flex; align-items:center; gap:.35rem">
        ← Назад к списку
    </a>
</div>

<div class="row justify-content-center">
    <div class="col-lg-7">
        <div class="glass overflow-hidden">

            {{-- Accent top bar --}}
            <div style="height:4px; background:linear-gradient(90deg, var(--accent), var(--accent2))"></div>

            <div class="p-4 p-md-5">
                {{-- Header --}}
                <div class="d-flex align-items-start justify-content-between gap-3 mb-4 flex-wrap">
                    <div style="flex:1; min-width:0">
                        <span class="s-pill {{ $sm['pill'] }} mb-2 d-inline-flex">{{ $sm['label'] }}</span>
                        <h1 style="font-size:1.5rem; font-weight:800; letter-spacing:-.02em; margin:0; word-break:break-word">
                            {{ $task->title }}
                        </h1>
                    </div>
                    <div class="d-flex gap-2 flex-shrink-0">
                        <a href="{{ route('tasks.edit', $task) }}" class="btn-icon edit" style="padding:.45rem 1rem">Изменить</a>
                        <form action="{{ route('tasks.destroy', $task) }}" method="POST"
                              onsubmit="return confirm('Удалить эту задачу?')">
                            @csrf @method('DELETE')
                            <button class="btn-icon del" style="padding:.45rem 1rem">Удалить</button>
                        </form>
                    </div>
                </div>

                <hr class="dim">

                {{-- Description --}}
                <div class="mb-4">
                    <div class="form-label mb-2">Описание</div>
                    @if($task->description)
                        <p style="white-space:pre-wrap; line-height:1.7; color:var(--text); font-size:.93rem; margin:0">{{ $task->description }}</p>
                    @else
                        <p style="color:var(--muted); font-style:italic; margin:0">Описание не указано</p>
                    @endif
                </div>

                <hr class="dim">

                {{-- Meta --}}
                <div class="d-flex gap-4 flex-wrap">
                    <div>
                        <div class="form-label mb-1">Создано</div>
                        <div style="font-size:.88rem">{{ $task->created_at->format('d.m.Y, H:i') }}</div>
                    </div>
                    <div>
                        <div class="form-label mb-1">Обновлено</div>
                        <div style="font-size:.88rem">{{ $task->updated_at->format('d.m.Y, H:i') }}</div>
                    </div>
                    <div>
                        <div class="form-label mb-1">ID</div>
                        <div style="font-size:.88rem; font-family:monospace">#{{ $task->id }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
