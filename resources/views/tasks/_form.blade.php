<div class="mb-3">
    <label for="title" class="form-label">Название <span class="text-danger">*</span></label>
    <input type="text" name="title" id="title" class="form-control @error('title') is-invalid @enderror"
           value="{{ old('title', $task->title ?? '') }}">
    @error('title')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label for="description" class="form-label">Описание</label>
    <textarea name="description" id="description" rows="4"
              class="form-control @error('description') is-invalid @enderror">{{ old('description', $task->description ?? '') }}</textarea>
    @error('description')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label for="status" class="form-label">Статус <span class="text-danger">*</span></label>
    <select name="status" id="status" class="form-select @error('status') is-invalid @enderror">
        @php
            $statuses = ['new' => 'Новая', 'in_progress' => 'В процессе', 'done' => 'Завершённая'];
            $current  = old('status', $task->status ?? 'new');
        @endphp
        @foreach($statuses as $value => $label)
            <option value="{{ $value }}" {{ $current === $value ? 'selected' : '' }}>{{ $label }}</option>
        @endforeach
    </select>
    @error('status')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>
