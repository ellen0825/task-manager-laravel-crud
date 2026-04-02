<div class="mb-4">
    <label for="title" class="form-label">Название <span style="color:var(--danger)">*</span></label>
    <input type="text" name="title" id="title"
           class="form-control @error('title') is-invalid @enderror"
           placeholder="Введите название задачи…"
           value="{{ old('title', $task->title ?? '') }}">
    @error('title')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-4">
    <label for="description" class="form-label">Описание</label>
    <textarea name="description" id="description" rows="5"
              class="form-control @error('description') is-invalid @enderror"
              placeholder="Добавьте описание задачи…">{{ old('description', $task->description ?? '') }}</textarea>
    @error('description')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-5">
    <label class="form-label">Статус <span style="color:var(--danger)">*</span></label>
    @php
        $statuses = [
            'new'         => ['label' => 'Новая',       'pill' => 's-new',  'desc' => 'Задача ещё не начата'],
            'in_progress' => ['label' => 'В процессе',  'pill' => 's-wip',  'desc' => 'Задача выполняется'],
            'done'        => ['label' => 'Завершённая', 'pill' => 's-done', 'desc' => 'Задача выполнена'],
        ];
        $current = old('status', $task->status ?? 'new');
    @endphp
    <div class="d-flex gap-2 flex-wrap">
        @foreach($statuses as $value => $info)
        <label class="status-option {{ $current === $value ? 'selected' : '' }}" for="status_{{ $value }}">
            <input type="radio" name="status" id="status_{{ $value }}" value="{{ $value }}"
                   {{ $current === $value ? 'checked' : '' }} style="display:none">
            <span class="s-pill {{ $info['pill'] }}">{{ $info['label'] }}</span>
            <span style="font-size:.75rem; color:var(--muted); margin-top:.2rem">{{ $info['desc'] }}</span>
        </label>
        @endforeach
    </div>
    @error('status')
        <div style="color:var(--danger); font-size:.78rem; margin-top:.4rem">{{ $message }}</div>
    @enderror
</div>

<style>
    .status-option {
        display: flex; flex-direction: column; align-items: flex-start; gap: .2rem;
        padding: .75rem 1rem;
        border: 1px solid var(--border);
        border-radius: 10px;
        cursor: pointer;
        transition: border-color .15s, background .15s;
        min-width: 130px;
    }
    .status-option:hover { border-color: rgba(255,255,255,.2); background: var(--surface2); }
    .status-option.selected { border-color: var(--accent); background: rgba(108,99,255,.08); }
</style>

<script>
    document.querySelectorAll('.status-option').forEach(el => {
        el.addEventListener('click', () => {
            document.querySelectorAll('.status-option').forEach(e => e.classList.remove('selected'));
            el.classList.add('selected');
        });
    });
</script>
