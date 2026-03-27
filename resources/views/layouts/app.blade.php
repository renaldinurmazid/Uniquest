<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? config('app.name') }} | UniQuest</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Rajdhani:wght@400;500;600;700&family=Nunito:wght@400;600;700;800;900&display=swap"
        rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles

    <style>
        [x-cloak] {
            display: none !important;
        }

        :root {
            --violet: #7c3aed;
            --violet-dark: #5b21b6;
            --violet-light: #8b5cf6;
            --violet-glow: #a78bfa;
            --violet-dim: #ede9fe;
            --neon: #c4b5fd;
            --gold: #f59e0b;
            --gold-light: #fde68a;
            --bg-dark: #0f0a1e;
            --bg-card: #1a1033;
            --bg-surface: #150d2b;
            --border-glow: rgba(124, 58, 237, 0.3);
            --text-dim: #a78bfa;
        }

        * {
            box-sizing: border-box;
        }

        body {
            font-family: 'Nunito', sans-serif;
            background: var(--bg-dark);
            color: #e2d9f3;
        }

        ::-webkit-scrollbar {
            width: 4px;
        }

        ::-webkit-scrollbar-track {
            background: var(--bg-dark);
        }

        ::-webkit-scrollbar-thumb {
            background: var(--violet);
            border-radius: 2px;
        }

        .sidebar {
            background: var(--bg-surface);
            border-right: 1px solid var(--border-glow);
            position: relative;
        }

        .sidebar::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%237c3aed' fill-opacity='0.03'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
            pointer-events: none;
        }

        .logo-glow {
            filter: drop-shadow(0 0 12px rgba(124, 58, 237, 0.8));
        }

        .nav-item {
            position: relative;
            transition: all 0.2s ease;
        }

        .nav-item:hover .nav-icon {
            transform: scale(1.15);
        }

        .nav-item.active {
            background: linear-gradient(90deg, rgba(124, 58, 237, 0.2), rgba(124, 58, 237, 0.05));
            border-left: 3px solid var(--violet-light);
        }

        .nav-item.active .nav-icon {
            background: var(--violet) !important;
            color: white !important;
            box-shadow: 0 0 16px rgba(124, 58, 237, 0.6);
        }

        .nav-section-label {
            font-family: 'Rajdhani', sans-serif;
            font-size: 10px;
            letter-spacing: 0.15em;
            color: rgba(167, 139, 250, 0.5);
            text-transform: uppercase;
            font-weight: 700;
        }

        .topbar {
            background: rgba(15, 10, 30, 0.95);
            border-bottom: 1px solid var(--border-glow);
            backdrop-filter: blur(20px);
        }

        .xp-bar-track {
            background: rgba(124, 58, 237, 0.15);
            border: 1px solid rgba(124, 58, 237, 0.3);
        }

        .xp-bar-fill {
            background: linear-gradient(90deg, var(--violet), var(--violet-glow));
            box-shadow: 0 0 10px rgba(124, 58, 237, 0.7);
            animation: xpPulse 2s ease-in-out infinite;
        }

        @keyframes xpPulse {

            0%,
            100% {
                opacity: 1
            }

            50% {
                opacity: 0.8
            }
        }

        .hex-badge {
            clip-path: polygon(50% 0%, 93% 25%, 93% 75%, 50% 100%, 7% 75%, 7% 25%);
            background: linear-gradient(135deg, var(--violet), var(--violet-dark));
        }

        .stat-card {
            background: var(--bg-card);
            border: 1px solid var(--border-glow);
            position: relative;
            overflow: hidden;
            transition: all 0.3s ease;
        }

        .stat-card::before {
            content: '';
            position: absolute;
            top: -1px;
            left: -1px;
            right: -1px;
            bottom: -1px;
            background: linear-gradient(135deg, rgba(124, 58, 237, 0.3), transparent 60%);
            border-radius: inherit;
            pointer-events: none;
            opacity: 0;
            transition: opacity 0.3s;
        }

        .stat-card:hover::before {
            opacity: 1;
        }

        .stat-card:hover {
            border-color: rgba(124, 58, 237, 0.6);
            box-shadow: 0 0 24px rgba(124, 58, 237, 0.2);
            transform: translateY(-2px);
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--violet), var(--violet-dark));
            box-shadow: 0 4px 20px rgba(124, 58, 237, 0.5), inset 0 1px 0 rgba(255, 255, 255, 0.1);
            transition: all 0.2s ease;
            font-family: 'Rajdhani', sans-serif;
            font-weight: 700;
            letter-spacing: 0.05em;
        }

        .btn-primary:hover {
            box-shadow: 0 8px 30px rgba(124, 58, 237, 0.7), inset 0 1px 0 rgba(255, 255, 255, 0.15);
            transform: translateY(-1px);
        }

        .btn-primary:active {
            transform: scale(0.97);
        }

        .btn-secondary {
            background: rgba(124, 58, 237, 0.08);
            border: 1px solid rgba(124, 58, 237, 0.3);
            color: var(--violet-glow);
            transition: all 0.2s ease;
            font-family: 'Rajdhani', sans-serif;
            font-weight: 700;
        }

        .btn-secondary:hover {
            background: rgba(124, 58, 237, 0.15);
            border-color: rgba(124, 58, 237, 0.6);
        }

        .role-badge {
            background: rgba(124, 58, 237, 0.15);
            border: 1px solid rgba(124, 58, 237, 0.35);
            color: var(--neon);
            font-family: 'Rajdhani', sans-serif;
            font-weight: 700;
            letter-spacing: 0.08em;
        }

        .data-table {
            border-collapse: separate;
            border-spacing: 0;
        }

        .data-table thead th {
            background: rgba(124, 58, 237, 0.08);
            font-family: 'Rajdhani', sans-serif;
            font-weight: 700;
            letter-spacing: 0.12em;
            color: rgba(167, 139, 250, 0.7);
            border-bottom: 1px solid var(--border-glow);
        }

        .data-table tbody tr {
            border-bottom: 1px solid rgba(124, 58, 237, 0.08);
            transition: all 0.2s ease;
        }

        .data-table tbody tr:hover {
            background: rgba(124, 58, 237, 0.06);
        }

        .search-input {
            background: rgba(124, 58, 237, 0.08);
            border: 1px solid rgba(124, 58, 237, 0.25);
            color: #e2d9f3;
            transition: all 0.2s ease;
        }

        .search-input:focus {
            background: rgba(124, 58, 237, 0.12);
            border-color: rgba(124, 58, 237, 0.6);
            box-shadow: 0 0 0 3px rgba(124, 58, 237, 0.1);
            outline: none;
        }

        .search-input::placeholder {
            color: rgba(167, 139, 250, 0.4);
        }

        .modal-panel {
            background: var(--bg-surface);
            border: 1px solid rgba(124, 58, 237, 0.4);
            box-shadow: 0 25px 80px rgba(0, 0, 0, 0.8), 0 0 60px rgba(124, 58, 237, 0.15);
        }

        .modal-input {
            background: rgba(124, 58, 237, 0.06);
            border: 1px solid rgba(124, 58, 237, 0.2);
            color: #e2d9f3;
            transition: all 0.2s ease;
        }

        .modal-input:focus {
            background: rgba(124, 58, 237, 0.1);
            border-color: rgba(124, 58, 237, 0.6);
            box-shadow: 0 0 0 3px rgba(124, 58, 237, 0.1);
            outline: none;
        }

        .modal-input::placeholder {
            color: rgba(167, 139, 250, 0.35);
        }

        .notif-dot {
            box-shadow: 0 0 8px rgba(239, 68, 68, 0.8);
            animation: notifPulse 1.5s ease-in-out infinite;
        }

        @keyframes notifPulse {

            0%,
            100% {
                transform: scale(1)
            }

            50% {
                transform: scale(1.3)
            }
        }

        .rank-star {
            filter: drop-shadow(0 0 4px rgba(245, 158, 11, 0.8));
        }

        .page-enter {
            animation: pageIn 0.4s ease forwards;
        }

        @keyframes pageIn {
            from {
                opacity: 0;
                transform: translateY(10px)
            }

            to {
                opacity: 1;
                transform: translateY(0)
            }
        }

        .inner-glow {
            box-shadow: inset 0 1px 0 rgba(124, 58, 237, 0.2), inset 0 -1px 0 rgba(0, 0, 0, 0.3);
        }

        .vr-line {
            background: linear-gradient(to bottom, transparent, var(--border-glow), transparent);
            width: 1px;
        }

        .profile-card {
            background: linear-gradient(135deg, rgba(124, 58, 237, 0.15), rgba(91, 33, 182, 0.1));
            border: 1px solid rgba(124, 58, 237, 0.3);
        }
    </style>
</head>

<body class="h-full overflow-hidden" x-data="{ sidebarOpen: false }">
    <div class="flex h-full">

        {{-- ========== MOBILE SIDEBAR ========== --}}
        <div x-show="sidebarOpen" class="fixed inset-0 z-40 flex md:hidden" x-cloak>
            <div x-show="sidebarOpen" x-transition:enter="transition-opacity ease-linear duration-300"
                x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                x-transition:leave="transition-opacity ease-linear duration-300" x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0" class="fixed inset-0 bg-black/80 backdrop-blur-sm"
                @click="sidebarOpen = false"></div>

            <div x-show="sidebarOpen" x-transition:enter="transition ease-in-out duration-300 transform"
                x-transition:enter-start="-translate-x-full" x-transition:enter-end="translate-x-0"
                x-transition:leave="transition ease-in-out duration-300 transform"
                x-transition:leave-start="translate-x-0" x-transition:leave-end="-translate-x-full"
                class="sidebar relative flex w-full max-w-xs flex-1 flex-col pt-5 pb-4">

                <div class="absolute top-0 right-0 -mr-12 pt-2">
                    <button type="button" class="ml-1 flex h-10 w-10 items-center justify-center rounded-full"
                        @click="sidebarOpen = false">
                        <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                {{-- Mobile Logo --}}
                <div class="flex items-center gap-3 px-7 pt-3 pb-8">
                    <div class="w-12 h-12 hex-badge flex items-center justify-center logo-glow flex-shrink-0">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                d="M13 10V3L4 14h7v7l9-11h-7z" />
                        </svg>
                    </div>
                    <div>
                        <div style="font-family:'Rajdhani',sans-serif;font-weight:700;font-size:1.5rem;letter-spacing:0.06em;line-height:1;"
                            class="text-white">
                            UNI<span style="color:#a78bfa">QUEST</span>
                        </div>
                        <div
                            style="font-size:10px;letter-spacing:0.15em;color:rgba(167,139,250,0.5);font-family:'Rajdhani',sans-serif;font-weight:600;">
                            ACADEMY GUILD
                        </div>
                    </div>
                </div>

                <div class="h-0 flex-1 overflow-y-auto px-4 space-y-6 pb-4">

                    {{-- ⚔ Main Hub --}}
                    <div>
                        <div class="px-3 mb-2">
                            <p class="nav-section-label">⚔ Main Hub</p>
                        </div>
                        <nav class="space-y-0.5">

                            {{-- Dashboard --}}
                            @can('dashboard.view')
                                @php $isActive = request()->routeIs('dashboard'); @endphp
                                <a href="{{ route('dashboard') }}"
                                    class="nav-item {{ $isActive ? 'active' : '' }} flex items-center px-3 py-3 rounded-xl text-sm font-bold transition-all duration-200 {{ $isActive ? 'text-violet-300' : 'text-purple-300/60 hover:text-purple-200 hover:bg-violet-900/20' }}">
                                    <div
                                        class="nav-icon w-8 h-8 rounded-lg flex items-center justify-center mr-3 transition-all {{ $isActive ? 'bg-violet-600 text-white' : 'bg-violet-900/30 text-violet-400' }}">
                                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                            stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                                        </svg>
                                    </div>
                                    Dashboard
                                </a>
                            @endcan

                            {{-- Quest Management --}}
                            @can('quest.view')
                                @php $isActive = request()->routeIs('quests*'); @endphp
                                <a href="{{ route('quests') }}"
                                    class="nav-item {{ $isActive ? 'active' : '' }} flex items-center px-3 py-3 rounded-xl text-sm font-bold transition-all duration-200 {{ $isActive ? 'text-violet-300' : 'text-purple-300/60 hover:text-purple-200 hover:bg-violet-900/20' }}">
                                    <div
                                        class="nav-icon w-8 h-8 rounded-lg flex items-center justify-center mr-3 transition-all {{ $isActive ? 'bg-violet-600 text-white' : 'bg-violet-900/30 text-violet-400' }}">
                                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                            stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7" />
                                        </svg>
                                    </div>
                                    Quest Management
                                </a>
                            @endcan

                            {{-- Leaderboard --}}
                            @can('leaderboard.view')
                                @php $isActive = request()->routeIs('leaderboard*'); @endphp
                                <a href="{{ route('leaderboard') }}"
                                    class="nav-item {{ $isActive ? 'active' : '' }} flex items-center px-3 py-3 rounded-xl text-sm font-bold transition-all duration-200 {{ $isActive ? 'text-violet-300' : 'text-purple-300/60 hover:text-purple-200 hover:bg-violet-900/20' }}">
                                    <div
                                        class="nav-icon w-8 h-8 rounded-lg flex items-center justify-center mr-3 transition-all {{ $isActive ? 'bg-violet-600 text-white' : 'bg-violet-900/30 text-violet-400' }}">
                                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                            stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                                        </svg>
                                    </div>
                                    Leaderboard
                                </a>
                            @endcan

                            {{-- Campus Insight --}}
                            @can('analytics.view')
                                @php $isActive = request()->routeIs('campus-insight*'); @endphp
                                <a href="{{ route('campus-insight') }}"
                                    class="nav-item {{ $isActive ? 'active' : '' }} flex items-center px-3 py-3 rounded-xl text-sm font-bold transition-all duration-200 {{ $isActive ? 'text-violet-300' : 'text-purple-300/60 hover:text-purple-200 hover:bg-violet-900/20' }}">
                                    <div
                                        class="nav-icon w-8 h-8 rounded-lg flex items-center justify-center mr-3 transition-all {{ $isActive ? 'bg-violet-600 text-white' : 'bg-violet-900/30 text-violet-400' }}">
                                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                            stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z" />
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z" />
                                        </svg>
                                    </div>
                                    Campus Insight
                                </a>
                            @endcan

                        </nav>
                    </div>

                    {{-- 🛡 Player & Guilds --}}
                    @canany(['student.view', 'org.view', 'skill.view', 'achievement.view'])
                        <div>
                            <div class="px-3 mb-2">
                                <p class="nav-section-label">🛡 Player &amp; Guilds</p>
                            </div>
                            <nav class="space-y-0.5">

                                @can('student.view')
                                    @php $isActive = request()->routeIs('students*'); @endphp
                                    <a href="{{ route('students') }}"
                                        class="nav-item {{ $isActive ? 'active' : '' }} flex items-center px-3 py-3 rounded-xl text-sm font-bold transition-all duration-200 {{ $isActive ? 'text-violet-300' : 'text-purple-300/60 hover:text-purple-200 hover:bg-violet-900/20' }}">
                                        <div
                                            class="nav-icon w-8 h-8 rounded-lg flex items-center justify-center mr-3 transition-all {{ $isActive ? 'bg-violet-600 text-white' : 'bg-violet-900/30 text-violet-400' }}">
                                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                                stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M12 14l9-5-9-5-9 5 9 5z" />
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z" />
                                            </svg>
                                        </div>
                                        Students
                                    </a>
                                @endcan

                                @can('org.view')
                                    @php $isActive = request()->routeIs('organizations*'); @endphp
                                    <a href="{{ route('organizations') }}"
                                        class="nav-item {{ $isActive ? 'active' : '' }} flex items-center px-3 py-3 rounded-xl text-sm font-bold transition-all duration-200 {{ $isActive ? 'text-violet-300' : 'text-purple-300/60 hover:text-purple-200 hover:bg-violet-900/20' }}">
                                        <div
                                            class="nav-icon w-8 h-8 rounded-lg flex items-center justify-center mr-3 transition-all {{ $isActive ? 'bg-violet-600 text-white' : 'bg-violet-900/30 text-violet-400' }}">
                                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                                stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                            </svg>
                                        </div>
                                        Organizations
                                    </a>
                                @endcan

                                @can('skill.view')
                                    @php $isActive = request()->routeIs('skills*'); @endphp
                                    <a href="{{ route('skills') }}"
                                        class="nav-item {{ $isActive ? 'active' : '' }} flex items-center px-3 py-3 rounded-xl text-sm font-bold transition-all duration-200 {{ $isActive ? 'text-violet-300' : 'text-purple-300/60 hover:text-purple-200 hover:bg-violet-900/20' }}">
                                        <div
                                            class="nav-icon w-8 h-8 rounded-lg flex items-center justify-center mr-3 transition-all {{ $isActive ? 'bg-violet-600 text-white' : 'bg-violet-900/30 text-violet-400' }}">
                                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                                stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M13 10V3L4 14h7v7l9-11h-7z" />
                                            </svg>
                                        </div>
                                        Skills Master
                                    </a>
                                @endcan

                                @can('achievement.view')
                                    @php $isActive = request()->routeIs('achievements*'); @endphp
                                    <a href="{{ route('achievements') }}"
                                        class="nav-item {{ $isActive ? 'active' : '' }} flex items-center px-3 py-3 rounded-xl text-sm font-bold transition-all duration-200 {{ $isActive ? 'text-violet-300' : 'text-purple-300/60 hover:text-purple-200 hover:bg-violet-900/20' }}">
                                        <div
                                            class="nav-icon w-8 h-8 rounded-lg flex items-center justify-center mr-3 transition-all {{ $isActive ? 'bg-violet-600 text-white' : 'bg-violet-900/30 text-violet-400' }}">
                                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                                stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.54 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.784.57-1.838-.196-1.539-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                                            </svg>
                                        </div>
                                        Achievements
                                    </a>
                                @endcan

                            </nav>
                        </div>
                    @endcanany

                    {{-- 💎 Economy & Vault --}}
                    @canany(['shop.view', 'verify.view'])
                        <div>
                            <div class="px-3 mb-2">
                                <p class="nav-section-label">💎 Economy &amp; Vault</p>
                            </div>
                            <nav class="space-y-0.5">

                                @can('shop.view')
                                    @php $isActive = request()->routeIs('point-shop*'); @endphp
                                    <a href="{{ route('point-shop') }}"
                                        class="nav-item {{ $isActive ? 'active' : '' }} flex items-center px-3 py-3 rounded-xl text-sm font-bold transition-all duration-200 {{ $isActive ? 'text-violet-300' : 'text-purple-300/60 hover:text-purple-200 hover:bg-violet-900/20' }}">
                                        <div
                                            class="nav-icon w-8 h-8 rounded-lg flex items-center justify-center mr-3 transition-all {{ $isActive ? 'bg-violet-600 text-white' : 'bg-violet-900/30 text-violet-400' }}">
                                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                                stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                                            </svg>
                                        </div>
                                        Point Shop
                                    </a>
                                @endcan

                                @can('verify.view')
                                    @php $isActive = request()->routeIs('verification*'); @endphp
                                    <a href="{{ route('verification') }}"
                                        class="nav-item {{ $isActive ? 'active' : '' }} flex items-center px-3 py-3 rounded-xl text-sm font-bold transition-all duration-200 {{ $isActive ? 'text-violet-300' : 'text-purple-300/60 hover:text-purple-200 hover:bg-violet-900/20' }}">
                                        <div
                                            class="nav-icon w-8 h-8 rounded-lg flex items-center justify-center mr-3 transition-all {{ $isActive ? 'bg-violet-600 text-white' : 'bg-violet-900/30 text-violet-400' }}">
                                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                                stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M9 12l2 2 4-4m5.618-4.016A3.323 3.323 0 0010.65 15c-1.838 0-3.33 1.492-3.33 3.331V21h10.681v-2.669c0-1.838-1.492-3.331-3.33-3.331a3.323 3.323 0 00-4.07 2.669m-.333-8.669c0-1.838 1.492-3.331 3.33-3.331a3.323 3.323 0 013.331 3.331c0 1.838-1.492 3.331-3.331 3.331a3.323 3.323 0 01-3.33-3.331z" />
                                            </svg>
                                        </div>
                                        Verification Center
                                    </a>
                                @endcan

                            </nav>
                        </div>
                    @endcanany

                    {{-- ⚙ System Admin --}}
                    @canany(['user.view', 'role.view'])
                        <div>
                            <div class="px-3 mb-2">
                                <p class="nav-section-label">⚙ System Admin</p>
                            </div>
                            <nav class="space-y-0.5">

                                @can('user.view')
                                    @php $isActive = request()->routeIs('users*'); @endphp
                                    <a href="{{ route('users') }}"
                                        class="nav-item {{ $isActive ? 'active' : '' }} flex items-center px-3 py-3 rounded-xl text-sm font-bold transition-all duration-200 {{ $isActive ? 'text-violet-300' : 'text-purple-300/60 hover:text-purple-200 hover:bg-violet-900/20' }}">
                                        <div
                                            class="nav-icon w-8 h-8 rounded-lg flex items-center justify-center mr-3 transition-all {{ $isActive ? 'bg-violet-600 text-white' : 'bg-violet-900/30 text-violet-400' }}">
                                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                                stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                            </svg>
                                        </div>
                                        Users
                                    </a>
                                @endcan

                                @can('role.view')
                                    @php $isActive = request()->routeIs('roles*'); @endphp
                                    <a href="{{ route('roles') }}"
                                        class="nav-item {{ $isActive ? 'active' : '' }} flex items-center px-3 py-3 rounded-xl text-sm font-bold transition-all duration-200 {{ $isActive ? 'text-violet-300' : 'text-purple-300/60 hover:text-purple-200 hover:bg-violet-900/20' }}">
                                        <div
                                            class="nav-icon w-8 h-8 rounded-lg flex items-center justify-center mr-3 transition-all {{ $isActive ? 'bg-violet-600 text-white' : 'bg-violet-900/30 text-violet-400' }}">
                                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                                stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z" />
                                            </svg>
                                        </div>
                                        Roles &amp; Access
                                    </a>
                                @endcan

                            </nav>
                        </div>
                    @endcanany

                </div>

                {{-- Profile Bottom (Mobile) --}}
                @php
                    $user = auth()->user();
                    $profile = $user?->studentProfile;
                    $roleName = $user?->getRoleNames()->first() ?? 'guest';
                    $roleLabels = [
                        'superadmin' => ['label' => '👑 Grand Master', 'color' => '#ffd700'],
                        'admin' => ['label' => '🛡️ Guild Admin', 'color' => '#a78bfa'],
                        'staff' => ['label' => '⚔️ Guild Staff', 'color' => '#60a5fa'],
                        'sub-admin' => ['label' => '🗡️ Sub Commander', 'color' => '#34d399'],
                        'verifier' => ['label' => '🔍 Verifier', 'color' => '#f472b6'],
                        'student' => ['label' => '🎓 Adventurer', 'color' => '#c4b5fd'],
                    ];
                    $roleInfo = $roleLabels[$roleName] ?? ['label' => '👤 Guest', 'color' => '#a78bfa'];
                    $level = $profile?->level ?? 0;
                    $currentExp = $profile?->current_exp ?? 0;
                    $expNeeded = $level * 1000;
                    $xpPercent = $expNeeded > 0 ? min(100, round(($currentExp / $expNeeded) * 100)) : 0;
                    $totalCoins = $profile?->total_coins ?? 0;
                    $hasProfile = $profile !== null;
                    $avatarSeed = urlencode($user?->name ?? 'hero');
                    $avatarUrl = $user?->avatar_url
                        ? asset($user->avatar_url)
                        : "https://api.dicebear.com/7.x/avataaars/svg?seed={$avatarSeed}";
                @endphp

                <div class="p-4 border-t border-violet-900/40">
                    <div class="profile-card rounded-2xl p-4 relative overflow-hidden">
                        <div class="absolute -right-6 -top-6 w-20 h-20 bg-violet-600/10 rounded-full blur-2xl"></div>
                        <div class="flex items-center gap-3 relative z-10">
                            <div class="relative flex-shrink-0">
                                <div class="w-10 h-10 rounded-xl border-2 overflow-hidden"
                                    style="border-color: {{ $roleInfo['color'] }}40;">
                                    <img src="{{ $avatarUrl }}" alt="{{ $user?->name }}"
                                        class="w-full h-full object-cover"
                                        onerror="this.src='https://api.dicebear.com/7.x/avataaars/svg?seed=fallback'">
                                </div>
                                @if ($hasProfile)
                                    <div class="absolute -bottom-1 -right-1 hex-badge flex items-center justify-center"
                                        style="width:20px;height:20px;font-size:8px;font-family:'Rajdhani',sans-serif;font-weight:700;color:white;">
                                        {{ $level }}
                                    </div>
                                @endif
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-bold text-white truncate">{{ $user?->name ?? 'Unknown' }}</p>
                                <p style="font-size:9px;font-family:'Rajdhani',sans-serif;letter-spacing:0.1em;color:{{ $roleInfo['color'] }};"
                                    class="uppercase truncate">{{ $roleInfo['label'] }}</p>
                            </div>
                            @if ($hasProfile)
                                <div class="flex-shrink-0 text-right">
                                    <p
                                        style="font-size:9px;font-family:'Rajdhani',sans-serif;color:rgba(167,139,250,0.5);">
                                        COINS</p>
                                    <p
                                        style="font-size:13px;font-family:'Rajdhani',sans-serif;font-weight:700;color:#ffd700;line-height:1;text-shadow:0 0 8px rgba(255,215,0,0.4);">
                                        {{ number_format($totalCoins) }}
                                    </p>
                                </div>
                            @endif
                        </div>

                        @if ($hasProfile)
                            <div class="mt-3 relative z-10">
                                <div class="flex justify-between items-center mb-1">
                                    <span
                                        style="font-size:9px;font-family:'Rajdhani',sans-serif;color:rgba(167,139,250,0.6);">⚡
                                        EXP — LV {{ $level }}</span>
                                    <span
                                        style="font-size:9px;font-family:'Rajdhani',sans-serif;color:#a78bfa;">{{ number_format($currentExp) }}
                                        / {{ number_format($expNeeded) }}</span>
                                </div>
                                <div class="xp-bar-track h-1.5 rounded-full relative overflow-hidden">
                                    <div class="xp-bar-fill h-full rounded-full transition-all duration-1000"
                                        style="width: {{ $xpPercent }}%"></div>
                                </div>
                                <p
                                    style="font-size:8px;font-family:'Rajdhani',sans-serif;color:rgba(167,139,250,0.4);text-align:right;margin-top:2px;">
                                    {{ $xpPercent }}% menuju LV {{ $level + 1 }}
                                </p>
                            </div>
                        @else
                            <div class="mt-3 relative z-10">
                                <div class="flex items-center gap-2 px-2 py-1.5 rounded-lg"
                                    style="background:rgba(124,58,237,0.1);border:1px solid rgba(124,58,237,0.2);">
                                    <span
                                        style="font-size:9px;font-family:'Rajdhani',sans-serif;letter-spacing:0.12em;color:rgba(167,139,250,0.6);">ROLE</span>
                                    <span
                                        style="font-size:10px;font-family:'Rajdhani',sans-serif;font-weight:700;color:{{ $roleInfo['color'] }};letter-spacing:0.05em;">{{ strtoupper($roleName) }}</span>
                                </div>
                            </div>
                        @endif

                        <form method="POST" action="{{ route('logout') }}" class="mt-3 relative z-10">
                            @csrf
                            <button type="submit"
                                class="w-full py-2 text-xs font-bold rounded-xl flex items-center justify-center gap-2 transition-all text-red-400/70 hover:text-red-400 hover:bg-red-400/10"
                                style="font-family:'Rajdhani',sans-serif;letter-spacing:0.06em;">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                </svg>
                                LOGOUT
                            </button>
                        </form>
                    </div>
                </div>

            </div>
        </div>

        {{-- ========== DESKTOP SIDEBAR ========== --}}
        <div class="hidden md:flex md:w-72 md:flex-col md:fixed md:inset-y-0 z-10 sidebar">
            {{-- Logo --}}
            <div class="flex items-center gap-3 px-7 pt-8 pb-8">
                <div class="w-12 h-12 hex-badge flex items-center justify-center logo-glow flex-shrink-0">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                            d="M13 10V3L4 14h7v7l9-11h-7z" />
                    </svg>
                </div>
                <div>
                    <div style="font-family:'Rajdhani',sans-serif;font-weight:700;font-size:1.5rem;letter-spacing:0.06em;line-height:1;"
                        class="text-white">
                        UNI<span style="color:#a78bfa">QUEST</span>
                    </div>
                    <div
                        style="font-size:10px;letter-spacing:0.15em;color:rgba(167,139,250,0.5);font-family:'Rajdhani',sans-serif;font-weight:600;">
                        ACADEMY GUILD
                    </div>
                </div>
            </div>

            {{-- Nav --}}
            <div class="flex-1 overflow-y-auto px-4 space-y-6 pb-4">

                {{-- ⚔ Main Hub --}}
                <div>
                    <div class="px-3 mb-2">
                        <p class="nav-section-label">⚔ Main Hub</p>
                    </div>
                    <nav class="space-y-0.5">
                        {{-- Dashboard: semua user yang bisa masuk dashboard --}}
                        @can('dashboard.view')
                            @php $isActive = request()->routeIs('dashboard'); @endphp
                            <a href="{{ route('dashboard') }}" wire:navigate.hover
                                class="nav-item {{ $isActive ? 'active' : '' }} flex items-center px-3 py-3 rounded-xl text-sm font-bold transition-all duration-200 {{ $isActive ? 'text-violet-300' : 'text-purple-300/60 hover:text-purple-200 hover:bg-violet-900/20' }}">
                                <div
                                    class="nav-icon w-8 h-8 rounded-lg flex items-center justify-center mr-3 transition-all {{ $isActive ? 'bg-violet-600 text-white' : 'bg-violet-900/30 text-violet-400' }}">
                                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                        stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                                    </svg>
                                </div>
                                Dashboard
                            </a>
                        @endcan

                        {{-- Quest Management --}}
                        @can('quest.view')
                            @php $isActive = request()->routeIs('quests*'); @endphp
                            <a href="{{ route('quests') }}" wire:navigate.hover
                                class="nav-item {{ $isActive ? 'active' : '' }} flex items-center px-3 py-3 rounded-xl text-sm font-bold transition-all duration-200 {{ $isActive ? 'text-violet-300' : 'text-purple-300/60 hover:text-purple-200 hover:bg-violet-900/20' }}">
                                <div
                                    class="nav-icon w-8 h-8 rounded-lg flex items-center justify-center mr-3 transition-all {{ $isActive ? 'bg-violet-600 text-white' : 'bg-violet-900/30 text-violet-400' }}">
                                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                        stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7" />
                                    </svg>
                                </div>
                                Quest Management
                            </a>
                        @endcan

                        {{-- Leaderboard --}}
                        @can('leaderboard.view')
                            @php $isActive = request()->routeIs('leaderboard*'); @endphp
                            <a href="{{ route('leaderboard') }}" wire:navigate.hover
                                class="nav-item {{ $isActive ? 'active' : '' }} flex items-center px-3 py-3 rounded-xl text-sm font-bold transition-all duration-200 {{ $isActive ? 'text-violet-300' : 'text-purple-300/60 hover:text-purple-200 hover:bg-violet-900/20' }}">
                                <div
                                    class="nav-icon w-8 h-8 rounded-lg flex items-center justify-center mr-3 transition-all {{ $isActive ? 'bg-violet-600 text-white' : 'bg-violet-900/30 text-violet-400' }}">
                                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                        stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                                    </svg>
                                </div>
                                Leaderboard
                            </a>
                        @endcan

                        {{-- Campus Insight --}}
                        @can('analytics.view')
                            @php $isActive = request()->routeIs('campus-insight*'); @endphp
                            <a href="{{ route('campus-insight') }}" wire:navigate.hover
                                class="nav-item {{ $isActive ? 'active' : '' }} flex items-center px-3 py-3 rounded-xl text-sm font-bold transition-all duration-200 {{ $isActive ? 'text-violet-300' : 'text-purple-300/60 hover:text-purple-200 hover:bg-violet-900/20' }}">
                                <div
                                    class="nav-icon w-8 h-8 rounded-lg flex items-center justify-center mr-3 transition-all {{ $isActive ? 'bg-violet-600 text-white' : 'bg-violet-900/30 text-violet-400' }}">
                                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                        stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z" />
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z" />
                                    </svg>
                                </div>
                                Campus Insight
                            </a>
                        @endcan
                    </nav>
                </div>

                {{-- 🛡 Player & Guilds --}}
                @canany(['student.view', 'org.view', 'skill.view', 'achievement.view'])
                    <div>
                        <div class="px-3 mb-2">
                            <p class="nav-section-label">🛡 Player &amp; Guilds</p>
                        </div>
                        <nav class="space-y-0.5">
                            @can('student.view')
                                @php $isActive = request()->routeIs('students*'); @endphp
                                <a href="{{ route('students') }}" wire:navigate.hover
                                    class="nav-item {{ $isActive ? 'active' : '' }} flex items-center px-3 py-3 rounded-xl text-sm font-bold transition-all duration-200 {{ $isActive ? 'text-violet-300' : 'text-purple-300/60 hover:text-purple-200 hover:bg-violet-900/20' }}">
                                    <div
                                        class="nav-icon w-8 h-8 rounded-lg flex items-center justify-center mr-3 transition-all {{ $isActive ? 'bg-violet-600 text-white' : 'bg-violet-900/30 text-violet-400' }}">
                                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                            stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M12 14l9-5-9-5-9 5 9 5z" />
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z" />
                                        </svg>
                                    </div>
                                    Students
                                </a>
                            @endcan

                            @can('org.view')
                                @php $isActive = request()->routeIs('organizations*'); @endphp
                                <a href="{{ route('organizations') }}" wire:navigate.hover
                                    class="nav-item {{ $isActive ? 'active' : '' }} flex items-center px-3 py-3 rounded-xl text-sm font-bold transition-all duration-200 {{ $isActive ? 'text-violet-300' : 'text-purple-300/60 hover:text-purple-200 hover:bg-violet-900/20' }}">
                                    <div
                                        class="nav-icon w-8 h-8 rounded-lg flex items-center justify-center mr-3 transition-all {{ $isActive ? 'bg-violet-600 text-white' : 'bg-violet-900/30 text-violet-400' }}">
                                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                            stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                        </svg>
                                    </div>
                                    Organizations
                                </a>
                            @endcan

                            @can('skill.view')
                                @php $isActive = request()->routeIs('skills*'); @endphp
                                <a href="{{ route('skills') }}" wire:navigate.hover
                                    class="nav-item {{ $isActive ? 'active' : '' }} flex items-center px-3 py-3 rounded-xl text-sm font-bold transition-all duration-200 {{ $isActive ? 'text-violet-300' : 'text-purple-300/60 hover:text-purple-200 hover:bg-violet-900/20' }}">
                                    <div
                                        class="nav-icon w-8 h-8 rounded-lg flex items-center justify-center mr-3 transition-all {{ $isActive ? 'bg-violet-600 text-white' : 'bg-violet-900/30 text-violet-400' }}">
                                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                            stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M13 10V3L4 14h7v7l9-11h-7z" />
                                        </svg>
                                    </div>
                                    Skills Master
                                </a>
                            @endcan

                            @can('achievement.view')
                                @php $isActive = request()->routeIs('achievements*'); @endphp
                                <a href="{{ route('achievements') }}" wire:navigate.hover
                                    class="nav-item {{ $isActive ? 'active' : '' }} flex items-center px-3 py-3 rounded-xl text-sm font-bold transition-all duration-200 {{ $isActive ? 'text-violet-300' : 'text-purple-300/60 hover:text-purple-200 hover:bg-violet-900/20' }}">
                                    <div
                                        class="nav-icon w-8 h-8 rounded-lg flex items-center justify-center mr-3 transition-all {{ $isActive ? 'bg-violet-600 text-white' : 'bg-violet-900/30 text-violet-400' }}">
                                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                            stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.54 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.784.57-1.838-.196-1.539-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                                        </svg>
                                    </div>
                                    Achievements
                                </a>
                            @endcan
                        </nav>
                    </div>
                @endcanany

                {{-- 💎 Economy & Vault --}}
                @canany(['shop.view', 'verify.view'])
                    <div>
                        <div class="px-3 mb-2">
                            <p class="nav-section-label">💎 Economy &amp; Vault</p>
                        </div>
                        <nav class="space-y-0.5">
                            @can('shop.view')
                                @php $isActive = request()->routeIs('point-shop*'); @endphp
                                <a href="{{ route('point-shop') }}" wire:navigate.hover
                                    class="nav-item {{ $isActive ? 'active' : '' }} flex items-center px-3 py-3 rounded-xl text-sm font-bold transition-all duration-200 {{ $isActive ? 'text-violet-300' : 'text-purple-300/60 hover:text-purple-200 hover:bg-violet-900/20' }}">
                                    <div
                                        class="nav-icon w-8 h-8 rounded-lg flex items-center justify-center mr-3 transition-all {{ $isActive ? 'bg-violet-600 text-white' : 'bg-violet-900/30 text-violet-400' }}">
                                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                            stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                                        </svg>
                                    </div>
                                    Point Shop
                                </a>
                            @endcan

                            @can('verify.view')
                                @php $isActive = request()->routeIs('verification*'); @endphp
                                <a href="{{ route('verification') }}" wire:navigate.hover
                                    class="nav-item {{ $isActive ? 'active' : '' }} flex items-center px-3 py-3 rounded-xl text-sm font-bold transition-all duration-200 {{ $isActive ? 'text-violet-300' : 'text-purple-300/60 hover:text-purple-200 hover:bg-violet-900/20' }}">
                                    <div
                                        class="nav-icon w-8 h-8 rounded-lg flex items-center justify-center mr-3 transition-all {{ $isActive ? 'bg-violet-600 text-white' : 'bg-violet-900/30 text-violet-400' }}">
                                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                            stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M9 12l2 2 4-4m5.618-4.016A3.323 3.323 0 0010.65 15c-1.838 0-3.33 1.492-3.33 3.331V21h10.681v-2.669c0-1.838-1.492-3.331-3.33-3.331a3.323 3.323 0 00-4.07 2.669m-.333-8.669c0-1.838 1.492-3.331 3.33-3.331a3.323 3.323 0 013.331 3.331c0 1.838-1.492 3.331-3.331 3.331a3.323 3.323 0 01-3.33-3.331z" />
                                        </svg>
                                    </div>
                                    Verification Center
                                </a>
                            @endcan
                        </nav>
                    </div>
                @endcanany

                {{-- ⚙ System Admin --}}
                @canany(['user.view', 'role.view'])
                    <div>
                        <div class="px-3 mb-2">
                            <p class="nav-section-label">⚙ System Admin</p>
                        </div>
                        <nav class="space-y-0.5">
                            @can('user.view')
                                @php $isActive = request()->routeIs('users*'); @endphp
                                <a href="{{ route('users') }}" wire:navigate.hover
                                    class="nav-item {{ $isActive ? 'active' : '' }} flex items-center px-3 py-3 rounded-xl text-sm font-bold transition-all duration-200 {{ $isActive ? 'text-violet-300' : 'text-purple-300/60 hover:text-purple-200 hover:bg-violet-900/20' }}">
                                    <div
                                        class="nav-icon w-8 h-8 rounded-lg flex items-center justify-center mr-3 transition-all {{ $isActive ? 'bg-violet-600 text-white' : 'bg-violet-900/30 text-violet-400' }}">
                                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                            stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                        </svg>
                                    </div>
                                    Users
                                </a>
                            @endcan

                            @can('role.view')
                                @php $isActive = request()->routeIs('roles*'); @endphp
                                <a href="{{ route('roles') }}" wire:navigate.hover
                                    class="nav-item {{ $isActive ? 'active' : '' }} flex items-center px-3 py-3 rounded-xl text-sm font-bold transition-all duration-200 {{ $isActive ? 'text-violet-300' : 'text-purple-300/60 hover:text-purple-200 hover:bg-violet-900/20' }}">
                                    <div
                                        class="nav-icon w-8 h-8 rounded-lg flex items-center justify-center mr-3 transition-all {{ $isActive ? 'bg-violet-600 text-white' : 'bg-violet-900/30 text-violet-400' }}">
                                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                            stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z" />
                                        </svg>
                                    </div>
                                    Roles &amp; Access
                                </a>
                            @endcan
                        </nav>
                    </div>
                @endcanany

            </div>

            {{-- Profile Bottom --}}
            @php
                $user = auth()->user();
                $profile = $user?->studentProfile; // null untuk non-student / belum ada profil
                $roleName = $user?->getRoleNames()->first() ?? 'guest';

                // ── Gamification title per role ───────────────────────────
                $roleLabels = [
                    'superadmin' => ['label' => '👑 Grand Master', 'color' => '#ffd700'],
                    'admin' => ['label' => '🛡️ Guild Admin', 'color' => '#a78bfa'],
                    'staff' => ['label' => '⚔️ Guild Staff', 'color' => '#60a5fa'],
                    'sub-admin' => ['label' => '🗡️ Sub Commander', 'color' => '#34d399'],
                    'verifier' => ['label' => '🔍 Verifier', 'color' => '#f472b6'],
                    'student' => ['label' => '🎓 Adventurer', 'color' => '#c4b5fd'],
                ];
                $roleInfo = $roleLabels[$roleName] ?? ['label' => '👤 Guest', 'color' => '#a78bfa'];

                // ── XP & Level (hanya student punya student_profile) ─────
                $level = $profile?->level ?? 0;
                $currentExp = $profile?->current_exp ?? 0;
                $expNeeded = $level * 1000; // formula: tiap level butuh level×1000 XP
                $xpPercent = $expNeeded > 0 ? min(100, round(($currentExp / $expNeeded) * 100)) : 0;
                $totalCoins = $profile?->total_coins ?? 0;
                $hasProfile = $profile !== null;

                // ── Avatar: pakai avatar_url kalau ada, fallback ke DiceBear ─
                $avatarSeed = urlencode($user?->name ?? 'hero');
                $avatarUrl = $user?->avatar_url
                    ? asset($user->avatar_url)
                    : "https://api.dicebear.com/7.x/avataaars/svg?seed={$avatarSeed}";
            @endphp

            <div class="p-4 border-t border-violet-900/40">
                <div class="profile-card rounded-2xl p-4 relative overflow-hidden">
                    {{-- BG glow --}}
                    <div class="absolute -right-6 -top-6 w-20 h-20 bg-violet-600/10 rounded-full blur-2xl"></div>

                    {{-- ── Avatar + Name + Role ── --}}
                    <div class="flex items-center gap-3 relative z-10">

                        {{-- Avatar with level badge --}}
                        <div class="relative flex-shrink-0">
                            <div class="w-10 h-10 rounded-xl border-2 overflow-hidden"
                                style="border-color: {{ $roleInfo['color'] }}40;">
                                <img src="{{ $avatarUrl }}" alt="{{ $user?->name }}"
                                    class="w-full h-full object-cover"
                                    onerror="this.src='https://api.dicebear.com/7.x/avataaars/svg?seed=fallback'">
                            </div>
                            @if ($hasProfile)
                                <div class="absolute -bottom-1 -right-1 hex-badge flex items-center justify-center"
                                    style="width:20px;height:20px;font-size:8px;font-family:'Rajdhani',sans-serif;font-weight:700;color:white;">
                                    {{ $level }}
                                </div>
                            @endif
                        </div>

                        {{-- Name + Role --}}
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-bold text-white truncate">
                                {{ $user?->name ?? 'Unknown' }}
                            </p>
                            <p style="font-size:9px;font-family:'Rajdhani',sans-serif;letter-spacing:0.1em;color:{{ $roleInfo['color'] }};"
                                class="uppercase truncate">
                                {{ $roleInfo['label'] }}
                            </p>
                        </div>

                        {{-- Coins (hanya tampil kalau punya profil) --}}
                        @if ($hasProfile)
                            <div class="flex-shrink-0 text-right">
                                <p
                                    style="font-size:9px;font-family:'Rajdhani',sans-serif;color:rgba(167,139,250,0.5);">
                                    COINS</p>
                                <p
                                    style="font-size:13px;font-family:'Rajdhani',sans-serif;font-weight:700;color:#ffd700;line-height:1;text-shadow:0 0 8px rgba(255,215,0,0.4);">
                                    {{ number_format($totalCoins) }}
                                </p>
                            </div>
                        @endif
                    </div>

                    {{-- ── XP Bar (hanya student / user yang punya profile) ── --}}
                    @if ($hasProfile)
                        <div class="mt-3 relative z-10">
                            <div class="flex justify-between items-center mb-1">
                                <span
                                    style="font-size:9px;font-family:'Rajdhani',sans-serif;color:rgba(167,139,250,0.6);">
                                    ⚡ EXP — LV {{ $level }}
                                </span>
                                <span style="font-size:9px;font-family:'Rajdhani',sans-serif;color:#a78bfa;">
                                    {{ number_format($currentExp) }} / {{ number_format($expNeeded) }}
                                </span>
                            </div>
                            <div class="xp-bar-track h-1.5 rounded-full relative overflow-hidden">
                                <div class="xp-bar-fill h-full rounded-full transition-all duration-1000"
                                    style="width: {{ $xpPercent }}%"></div>
                            </div>
                            <p
                                style="font-size:8px;font-family:'Rajdhani',sans-serif;color:rgba(167,139,250,0.4);text-align:right;margin-top:2px;">
                                {{ $xpPercent }}% menuju LV {{ $level + 1 }}
                            </p>
                        </div>
                    @else
                        {{-- Non-student: tampilkan role badge saja --}}
                        <div class="mt-3 relative z-10">
                            <div class="flex items-center gap-2 px-2 py-1.5 rounded-lg"
                                style="background:rgba(124,58,237,0.1);border:1px solid rgba(124,58,237,0.2);">
                                <span
                                    style="font-size:9px;font-family:'Rajdhani',sans-serif;letter-spacing:0.12em;color:rgba(167,139,250,0.6);">
                                    ROLE
                                </span>
                                <span
                                    style="font-size:10px;font-family:'Rajdhani',sans-serif;font-weight:700;color:{{ $roleInfo['color'] }};letter-spacing:0.05em;">
                                    {{ strtoupper($roleName) }}
                                </span>
                            </div>
                        </div>
                    @endif

                    {{-- ── Logout ── --}}
                    <form method="POST" action="{{ route('logout') }}" class="mt-3 relative z-10">
                        @csrf
                        <button type="submit"
                            class="w-full py-2 text-xs font-bold rounded-xl flex items-center justify-center gap-2 transition-all text-red-400/70 hover:text-red-400 hover:bg-red-400/10"
                            style="font-family:'Rajdhani',sans-serif;letter-spacing:0.06em;">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                            </svg>
                            LOGOUT
                        </button>
                    </form>
                </div>
            </div>
        </div>

        {{-- ========== MAIN CONTENT ========== --}}
        <div class="flex flex-col flex-1 h-full overflow-hidden">

            {{-- Topbar --}}
            <header class="topbar h-16 sticky top-0 z-30 px-4 sm:px-8 flex items-center justify-between">
                <div class="flex items-center gap-4">
                    <button type="button"
                        class="md:hidden p-2 text-violet-400 hover:text-violet-300 transition-colors"
                        @click="sidebarOpen = true">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h7" />
                        </svg>
                    </button>
                    <nav class="flex" aria-label="Breadcrumb">
                        <ol class="flex items-center space-x-2">
                            <li>
                                <a href="{{ route('dashboard') }}"
                                    class="text-violet-500 hover:text-violet-300 transition-colors">
                                    <svg class="h-4 w-4" fill="none" viewBox="0 0 20 20" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                            d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z" />
                                    </svg>
                                </a>
                            </li>
                            @if (isset($breadcrumbs))
                                @foreach ($breadcrumbs as $breadcrumb)
                                    <li class="flex items-center">
                                        <span class="text-violet-800 mx-1">/</span>
                                        <a href="{{ $breadcrumb['url'] }}"
                                            class="text-violet-500 hover:text-violet-300 text-xs font-bold transition-colors"
                                            style="font-family:'Rajdhani',sans-serif;letter-spacing:0.05em;">{{ $breadcrumb['label'] }}</a>
                                    </li>
                                @endforeach
                            @endif
                            <li class="flex items-center">
                                <span class="text-violet-800 mx-1">/</span>
                                <span class="text-violet-200 text-xs font-bold"
                                    style="font-family:'Rajdhani',sans-serif;letter-spacing:0.05em;"
                                    aria-current="page">{{ $title ?? 'Dashboard' }}</span>
                            </li>
                        </ol>
                    </nav>
                </div>
            </header>

            {{-- Main Scrollable Content --}}
            <main class="flex-1 overflow-y-auto" style="background:var(--bg-dark);">
                <div class="py-8 px-4 sm:px-8 mx-auto page-enter">

                    @if (session('status'))
                        <div class="mb-6 p-4 rounded-xl flex items-center gap-3"
                            style="background:rgba(16,185,129,0.1);border:1px solid rgba(16,185,129,0.3);">
                            <svg class="w-5 h-5 text-emerald-400" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <p class="text-sm font-bold text-emerald-300"
                                style="font-family:'Rajdhani',sans-serif;letter-spacing:0.05em;">
                                {{ session('status') }}
                            </p>
                        </div>
                    @endif

                    {{ $slot }}
                </div>

                <footer class="py-6 px-8 border-t flex flex-col sm:flex-row justify-between items-center gap-4"
                    style="border-color:rgba(124,58,237,0.15);">
                    <p
                        style="font-size:11px;font-family:'Rajdhani',sans-serif;color:rgba(167,139,250,0.4);letter-spacing:0.06em;">
                        © {{ date('Y') }} UNIQUEST ACADEMY — ALL RIGHTS RESERVED
                    </p>
                    <div class="flex gap-6">
                        @foreach (['Documentation', 'Privacy Policy', 'Support'] as $link)
                            <a href="#"
                                style="font-size:11px;font-family:'Rajdhani',sans-serif;color:rgba(167,139,250,0.4);letter-spacing:0.05em;"
                                class="hover:text-violet-400 transition-colors">{{ strtoupper($link) }}</a>
                        @endforeach
                    </div>
                </footer>
            </main>
        </div>

    </div>
    @livewireScripts
</body>

</html>
