@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-7">
        <div class="card">
            <div class="card-header">Создать задачу</div>
            <div class="card-body">
                <form action="{{ route('tasks.store') }}" method="POST">
                    @csrf
                    @include('tasks._form')
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">Создать</button>
                        <a href="{{ route('tasks.index') }}" class="btn btn-secondary">Отмена</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
