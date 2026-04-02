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
            <div class="mb-4">
                <div style="font-size:1.35rem; font-weight:800; letter-spacing:-.02em">Новая задача</div>
                <div class="text-muted" style="font-size:.85rem; margin-top:.2rem">Заполните поля ниже</div>
            </div>
            <hr class="dim">
            <form action="{{ route('tasks.store') }}" method="POST">
                @csrf
                @include('tasks._form')
                <div class="d-flex gap-2">
                    <button type="submit" class="btn-accent btn">Создать задачу</button>
                    <a href="{{ route('tasks.index') }}" class="btn-ghost btn">Отмена</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
