<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Manajemen Produk')</title>
    <style>
        :root {
            --bg: #f8fafc;
            --panel: #ffffff;
            --panel-soft: #f1f5f9;
            --text: #0f172a;
            --muted: #64748b;
            --line: #e2e8f0;
            --primary: #0f172a;
            --primary-hover: #1e293b;
            --success-bg: #dcfce7;
            --success-text: #166534;
            --error-bg: #fee2e2;
            --error-text: #b91c1c;
        }

        * { box-sizing: border-box; }

        body {
            margin: 0;
            font-family: Arial, Helvetica, sans-serif;
            background: var(--bg);
            color: var(--text);
        }

        a { text-decoration: none; }

        a:focus-visible,
        button:focus-visible,
        input:focus-visible,
        select:focus-visible,
        textarea:focus-visible {
            outline: 3px solid #93c5fd;
            outline-offset: 2px;
        }

        .navbar {
            background: rgba(255, 255, 255, 0.96);
            border-bottom: 1px solid var(--line);
            position: sticky;
            top: 0;
            z-index: 10;
        }

        .navbar-inner {
            max-width: 1100px;
            margin: 0 auto;
            padding: 14px 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
        }

        .brand {
            display: flex;
            align-items: center;
            gap: 12px;
            color: var(--text);
            font-weight: 700;
        }

        .brand-mark {
            width: 36px;
            height: 36px;
            border-radius: 12px;
            background: var(--primary);
            color: #fff;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 0.9rem;
        }

        .nav-links {
            display: flex;
            align-items: center;
            gap: 8px;
            flex-wrap: wrap;
        }

        .nav-link {
            padding: 10px 12px;
            border-radius: 10px;
            color: var(--muted);
            font-size: 0.95rem;
            font-weight: 600;
        }

        .nav-link:hover {
            background: var(--panel-soft);
            color: var(--text);
        }

        .nav-link.primary {
            background: var(--primary);
            color: #fff;
        }

        .nav-link.primary:hover {
            background: var(--primary-hover);
            color: #fff;
        }

        .container {
            max-width: 1100px;
            margin: 0 auto;
            padding: 28px 20px 40px;
        }

        .alert {
            margin-bottom: 24px;
            border-radius: 14px;
            padding: 14px 16px;
            border: 1px solid #bbf7d0;
            background: var(--success-bg);
            color: var(--success-text);
            font-weight: 600;
        }

        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 16px;
            margin-bottom: 20px;
        }

        .eyebrow {
            margin: 0;
            font-size: 0.78rem;
            letter-spacing: 0.18em;
            text-transform: lowercase;
            color: var(--muted);
            font-weight: 700;
        }

        .page-title {
            margin: 8px 0 0;
            font-size: clamp(1.75rem, 3vw, 2.4rem);
            line-height: 1.2;
        }

        .button {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 12px;
            border: 1px solid transparent;
            padding: 10px 15px;
            font: inherit;
            font-weight: 700;
            cursor: pointer;
            transition: 0.2s ease;
        }

        .button-primary {
            background: var(--primary);
            color: #fff;
        }

        .button-primary:hover { background: var(--primary-hover); }

        .button-secondary {
            background: #fff;
            border-color: var(--line);
            color: var(--text);
        }

        .button-danger {
            background: #dc2626;
            color: #fff;
        }

        .button-danger:hover { background: #b91c1c; }

        .card {
            background: var(--panel);
            border: 1px solid var(--line);
            border-radius: 18px;
            overflow: hidden;
            box-shadow: 0 1px 2px rgba(15, 23, 42, 0.04);
        }

        table {
            width: 100%;
            min-width: 640px;
            border-collapse: collapse;
        }

        th, td {
            padding: 14px 16px;
            border-bottom: 1px solid var(--line);
            text-align: left;
            vertical-align: middle;
        }

        thead {
            background: #f8fafc;
        }

        th {
            font-size: 0.78rem;
            letter-spacing: 0.12em;
            color: var(--muted);
            font-weight: 700;
        }

        tbody tr:hover {
            background: #f8fafc;
        }

        .badge {
            display: inline-block;
            padding: 6px 10px;
            border-radius: 999px;
            background: var(--panel-soft);
            color: var(--muted);
            font-size: 0.78rem;
            font-weight: 700;
        }

        .empty-state {
            text-align: center;
            padding: 60px 20px;
        }

        .empty-state .icon {
            width: 48px;
            height: 48px;
            margin: 0 auto 16px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            background: var(--panel-soft);
            color: var(--muted);
            font-weight: 700;
        }

        .form-card {
            background: var(--panel);
            border: 1px solid var(--line);
            border-radius: 18px;
            padding: 24px;
        }

        .form-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 20px;
        }

        .field {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .field.full {
            grid-column: 1 / -1;
        }

        label {
            font-size: 0.92rem;
            font-weight: 700;
            color: var(--text);
        }

        input, select, textarea {
            width: 100%;
            border: 1px solid var(--line);
            border-radius: 12px;
            padding: 12px 14px;
            font-size: 0.96rem;
            background: #fff;
            color: var(--text);
        }

        input:focus, select:focus, textarea:focus {
            outline: 2px solid rgba(15, 23, 42, 0.15);
            border-color: #cbd5e1;
        }

        .error-message {
            font-size: 0.82rem;
            color: var(--error-text);
            margin-top: 4px;
        }

        .form-actions {
            display: flex;
            justify-content: flex-end;
            gap: 10px;
            margin-top: 24px;
        }

        .pagination {
            display: flex;
            justify-content: center;
            padding: 18px 0 6px;
            gap: 8px;
            flex-wrap: wrap;
        }

        .pagination a,
        .pagination span {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 36px;
            padding: 8px 10px;
            border-radius: 8px;
            font-size: 0.9rem;
            border: 1px solid var(--line);
            background: #fff;
            color: var(--text);
        }

        .pagination .current {
            background: var(--primary);
            border-color: var(--primary);
            color: #fff;
        }

        @media (max-width: 768px) {
            .container {
                padding: 22px 16px 32px;
            }

            .page-header {
                flex-direction: column;
                align-items: flex-start;
            }

            .form-grid {
                grid-template-columns: 1fr;
            }

            .navbar-inner {
                align-items: flex-start;
                flex-direction: column;
            }
        }

        .badge-makanan {
            background: #dcfce7;
            color: #166534;
        }

        .badge-rumah-tangga {
            background: #dbeafe;
            color: #1e40af;
        }

        .stok-menipis {
            color: #dc2626;
            font-weight: 700;
        }

        .nav-link[aria-current="page"] {
            background: var(--panel-soft);
            color: var(--text);
        }

        .nav-link.primary[aria-current="page"] {
            background: var(--primary);
            color: #fff;
        }

        .card,
        .form-card {
            box-shadow: 0 4px 14px rgba(15, 23, 42, 0.06);
        }

        .button-primary {
            box-shadow: 0 2px 8px rgba(15, 23, 42, 0.2);
        }

        .button-primary:hover {
            transform: translateY(-1px);
        }

        input:focus, select:focus {
            border-color: var(--primary);
        }

        :root {
            --surface-shadow: 0 8px 24px rgba(15, 23, 42, 0.06);
            --warning-text: #a16207;
            --danger-text: #b91c1c;
        }

        .filter-card,
        .summary-card {
            background: var(--panel);
            border: 1px solid var(--line);
            border-radius: 18px;
            box-shadow: var(--surface-shadow);
        }

        .filter-card {
            margin-bottom: 18px;
            padding: 20px;
        }

        .filter-grid {
            display: grid;
            grid-template-columns: minmax(0, 1.5fr) repeat(2, minmax(0, 1fr));
            gap: 16px;
        }

        .filter-grid .field {
            min-width: 0;
        }

        .filter-actions {
            display: flex;
            justify-content: flex-end;
            gap: 10px;
            margin-top: 16px;
        }

        .summary-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 16px;
            margin-bottom: 20px;
        }

        .summary-card {
            display: flex;
            flex-direction: column;
            gap: 6px;
            padding: 20px 22px;
        }

        .summary-card strong {
            font-size: 1.8rem;
            line-height: 1.1;
            font-variant-numeric: tabular-nums;
        }

        .summary-label {
            color: var(--muted);
            font-size: 0.85rem;
            font-weight: 700;
        }

        .summary-detail {
            color: var(--muted);
            font-size: 0.82rem;
        }

        .summary-card-warning strong {
            color: var(--warning-text);
        }

        .table-container {
            overflow-x: auto;
        }

        .table-container table {
            min-width: 720px;
        }

        .price-cell {
            color: var(--text);
            font-variant-numeric: tabular-nums;
            font-weight: 700;
            white-space: nowrap;
            text-align: right;
        }

        .badge-category {
            background: hsl(var(--badge-hue) 72% 93%);
            color: hsl(var(--badge-hue) 48% 30%);
        }

        .stok-cell {
            font-variant-numeric: tabular-nums;
            font-weight: 700;
            white-space: nowrap;
        }

        .stok-cell::before {
            display: inline-block;
            width: 8px;
            height: 8px;
            margin-right: 8px;
            border-radius: 50%;
            background: currentColor;
            content: "";
            vertical-align: 1px;
        }

        .stok-menipis {
            color: var(--danger-text);
        }

        .stok-cukup {
            color: #a16207;
        }

        .stok-aman {
            color: #15803d;
        }

        .button-danger.button-danger-outline {
            border-color: #fecaca;
            background: #fff;
            color: var(--danger-text);
            box-shadow: none;
        }

        .button-danger.button-danger-outline:hover {
            border-color: #dc2626;
            background: #dc2626;
            color: #fff;
        }

        .page-subtitle {
            margin: 10px 0 0;
            color: var(--muted);
            line-height: 1.6;
        }

        .form-card-head {
            margin-bottom: 24px;
        }

        .form-card-head h2 {
            margin: 0;
            font-size: 1.15rem;
        }

        .form-card-head p,
        .field-hint {
            margin: 6px 0 0;
            color: var(--muted);
            font-size: 0.86rem;
            line-height: 1.5;
        }

        .input-group {
            display: flex;
            overflow: hidden;
            border: 1px solid var(--line);
            border-radius: 12px;
            background: #fff;
            transition: border-color 0.2s ease, box-shadow 0.2s ease;
        }

        .input-group:focus-within {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(15, 23, 42, 0.1);
        }

        .input-group .input-prefix {
            display: inline-flex;
            align-items: center;
            padding: 0 14px;
            border-right: 1px solid var(--line);
            background: var(--panel-soft);
            color: var(--muted);
            font-weight: 700;
        }

        .input-group input {
            min-width: 0;
            border: 0;
            border-radius: 0;
            box-shadow: none;
        }

        .input-group input:focus {
            outline: 0;
        }

        input.is-invalid,
        select.is-invalid {
            border-color: #ef4444;
            background: #fffafa;
        }

        .input-group input.is-invalid {
            border-color: transparent;
            background: #fffafa;
        }

        .error-message {
            font-weight: 600;
            line-height: 1.45;
        }

        .alert-error {
            margin-bottom: 18px;
            border-color: #fecaca;
            background: var(--error-bg);
            color: var(--error-text);
        }

        .form-card,
        .card {
            box-shadow: var(--surface-shadow);
        }

        .button,
        .nav-link,
        .pagination a {
            transition: color 0.18s ease, background-color 0.18s ease, border-color 0.18s ease, box-shadow 0.18s ease, transform 0.18s ease;
        }

        .button:hover {
            transform: translateY(-1px);
        }

        .pagination-links {
            display: flex;
            width: 100%;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
        }

        .pagination-controls {
            display: flex;
            align-items: center;
            justify-content: flex-end;
            gap: 6px;
            flex-wrap: wrap;
        }

        .pagination .current {
            font-weight: 700;
        }

        .pagination .pagination-disabled {
            color: #94a3b8;
            cursor: not-allowed;
        }

        @media (max-width: 768px) {
            .filter-grid,
            .summary-grid {
                grid-template-columns: 1fr;
            }

            .filter-card,
            .form-card {
                padding: 18px;
            }

            .pagination-links {
                align-items: flex-start;
                flex-direction: column;
            }

            .pagination-controls {
                justify-content: flex-start;
            }
        }
    </style>
</head>
<body>
    <nav class="navbar">
        <div class="navbar-inner">
            <a href="{{ route('produk.index') }}" class="brand">
                <span class="brand-mark" aria-hidden="true">P</span>
                <span>Manajemen Produk</span>
            </a>

            <div class="nav-links">
                <a href="{{ route('produk.index') }}" class="nav-link" @if (request()->routeIs('produk.index')) aria-current="page" @endif>Daftar Produk</a>
                <a href="{{ route('produk.create') }}" class="nav-link primary" @if (request()->routeIs('produk.create')) aria-current="page" @endif>Tambah Produk</a>
            </div>
        </div>
    </nav>

    <main class="container">
        @if (session('success'))
            <div class="alert" role="status">
                {{ session('success') }}
            </div>
        @endif

        @yield('content')
    </main>
</body>
</html>