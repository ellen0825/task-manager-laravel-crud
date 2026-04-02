<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Менеджер задач</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --bg:        #0f1117;
            --surface:   #1a1d27;
            --surface2:  #222636;
            --border:    rgba(255,255,255,.07);
            --accent:    #6c63ff;
            --accent2:   #a78bfa;
            --text:      #e2e8f0;
            --muted:     #64748b;
            --new:       #334155;
            --new-text:  #94a3b8;
            --wip:       #422006;
            --wip-text:  #fb923c;
            --done:      #052e16;
            --done-text: #4ade80;
            --danger:    #ef4444;
            --radius:    14px;
        }

        *, *::before, *::after { box-sizing: border-box; }

        body {
            font-family: 'Inter', sans-serif;
            background: var(--bg);
            color: var(--text);
            min-height: 100vh;
        }

        /* ── Navbar ── */
        .app-nav {
            background: rgba(26,29,39,.85);
            backdrop-filter: blur(16px);
            border-bottom: 1px solid var(--border);
            padding: .9rem 0;
            position: sticky;
            top: 0;
            z-index: 100;
        }
        .app-nav .brand {
            font-weight: 700;
            font-size: 1.1rem;
            color: var(--text);
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: .5rem;
        }
        .brand-icon {
            width: 32px; height: 32px;
            background: linear-gradient(135deg, var(--accent), var(--accent2));
            border-radius: 8px;
            display: flex; align-items: center; justify-content: center;
            font-size: .9rem;
        }

        /* ── Page wrapper ── */
        .page { padding: 2.5rem 0 4rem; }

        /* ── Cards ── */
        .glass {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: var(--radius);
        }
        .glass-2 {
            background: var(--surface2);
            border: 1px solid var(--border);
            border-radius: var(--radius);
        }

        /* ── Buttons ── */
        .btn-accent {
            background: linear-gradient(135deg, var(--accent), var(--accent2));
            color: #fff;
            border: none;
            font-weight: 600;
            border-radius: 10px;
            padding: .55rem 1.3rem;
            transition: opacity .15s, transform .1s;
        }
        .btn-accent:hover { opacity: .88; color: #fff; transform: translateY(-1px); }

        .btn-ghost {
            background: transparent;
            border: 1px solid var(--border);
            color: var(--muted);
            border-radius: 10px;
            padding: .5rem 1.1rem;
            font-weight: 500;
            transition: border-color .15s, color .15s;
        }
        .btn-ghost:hover { border-color: var(--accent2); color: var(--text); }

        .btn-icon {
            background: transparent;
            border: 1px solid var(--border);
            color: var(--muted);
            border-radius: 8px;
            padding: .3rem .65rem;
            font-size: .78rem;
            font-weight: 500;
            transition: all .15s;
            white-space: nowrap;
        }
        .btn-icon:hover { color: var(--text); border-color: rgba(255,255,255,.2); }
        .btn-icon.edit:hover  { border-color: #f59e0b; color: #f59e0b; }
        .btn-icon.del:hover   { border-color: var(--danger); color: var(--danger); }
        .btn-icon.view:hover  { border-color: var(--accent2); color: var(--accent2); }

        /* ── Status pills ── */
        .s-pill {
            display: inline-flex; align-items: center; gap: .35rem;
            font-size: .7rem; font-weight: 600; letter-spacing: .05em;
            text-transform: uppercase; border-radius: 50px;
            padding: .28em .8em;
        }
        .s-pill::before { content:''; width:6px; height:6px; border-radius:50%; flex-shrink:0; }
        .s-new  { background: var(--new);  color: var(--new-text);  }
        .s-new::before  { background: var(--new-text); }
        .s-wip  { background: var(--wip);  color: var(--wip-text);  }
        .s-wip::before  { background: var(--wip-text); box-shadow: 0 0 6px var(--wip-text); }
        .s-done { background: var(--done); color: var(--done-text); }
        .s-done::before { background: var(--done-text); box-shadow: 0 0 6px var(--done-text); }

        /* ── Form controls ── */
        .form-control, .form-select {
            background: var(--surface2);
            border: 1px solid var(--border);
            color: var(--text);
            border-radius: 10px;
            padding: .65rem 1rem;
            transition: border-color .15s, box-shadow .15s;
        }
        .form-control:focus, .form-select:focus {
            background: var(--surface2);
            border-color: var(--accent);
            box-shadow: 0 0 0 3px rgba(108,99,255,.2);
            color: var(--text);
        }
        .form-control::placeholder { color: var(--muted); }
        .form-select option { background: var(--surface2); }
        .form-label { font-size: .82rem; font-weight: 600; color: var(--muted); letter-spacing: .04em; text-transform: uppercase; margin-bottom: .4rem; }
        .invalid-feedback { font-size: .78rem; }
        .form-control.is-invalid, .form-select.is-invalid { border-color: var(--danger); }

        /* ── Alert ── */
        .toast-success {
            background: #052e16;
            border: 1px solid #166534;
            color: #4ade80;
            border-radius: 10px;
            padding: .75rem 1.1rem;
            font-size: .88rem;
            font-weight: 500;
            display: flex; align-items: center; gap: .6rem;
        }

        /* ── Divider ── */
        hr.dim { border-color: var(--border); margin: 1.25rem 0; }

        /* ── Misc ── */
        .text-muted { color: var(--muted) !important; }
        a { color: inherit; }
        .page-title { font-size: 1.6rem; font-weight: 800; letter-spacing: -.02em; }
        .page-sub   { color: var(--muted); font-size: .88rem; margin-top: .2rem; }
    </style>
</head>
<body>

<nav class="app-nav">
    <div class="container d-flex align-items-center justify-content-between">
        <a href="{{ route('tasks.index') }}" class="brand">
            <span class="brand-icon">✓</span>
            Менеджер задач
        </a>
        <a href="{{ route('tasks.create') }}" class="btn-accent btn" style="font-size:.85rem;padding:.45rem 1rem;">
            + Новая задача
        </a>
    </div>
</nav>

<div class="page">
    <div class="container" style="max-width:860px">
        @if(session('success'))
            <div class="toast-success mb-4">
                <span>✓</span> {{ session('success') }}
            </div>
        @endif
        @yield('content')
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
