@extends('layouts.app')

@section('content')
<div class="mb-4">
    <a href="{{ route('tasks.index') }}" style="color:var(--muted); text-decoration:none; font-size:.85rem; display:inline-flex; align-items:center; gap:.35rem">
        ← Назад к списку
    </a>
</div>

<div class="row justify-content-center">
    <div class="col-lg-7">
        <div class="glass p-4 p-md-5">
            <div class="d-flex align-items-start justify-content-between mb-4 flex-wrap gap-2">
                <div>
                    <div style="font-size:1.35rem; font-weight:800; letter-spacing:-.02em">Редактировать задачу</div>
                    <div class="text-muted" style="font-size:.85rem; margin-top:.2rem">#{{ $task->id }} · создана {{ $task->created_at->format('d.m.Y') }}</div>
                </div>
                <form action="{{ route('tasks.destroy', $task) }}" method="POST"
                      onsubmit="return confirm('Удалить эту задачу?')">
                    @csrf @method('DELETE')
                    <button class="btn-icon del" style="padding:.4rem .9rem">Удалить</button>
                </form>
            </div>
            <hr class="dim">
            <form action="{{ route('tasks.update', $task) }}" method="POST">
                @csrf @method('PUT')
                @include('tasks._form')
                <div class="d-flex gap-2">
                    <button type="submit" class="btn-accent btn">Сохранить изменения</button>
                    <a href="{{ route('tasks.index') }}" class="btn-ghost btn">Отмена</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
