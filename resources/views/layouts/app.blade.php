<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-slate-50">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? config('app.name') }} | UniQuest</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        [x-cloak] { display: none !important; }
        body { font-family: 'Poppins', sans-serif; }
    </style>
</head>
<body class="h-full overflow-hidden" x-data="{ sidebarOpen: false }">
    <div class="flex h-full">
        <!-- Sidebar and Backdrop for Mobile -->
        <div x-show="sidebarOpen" 
             class="fixed inset-0 z-40 flex md:hidden" 
             x-ref="dialog" 
             aria-modal="true"
             x-cloak>
            <div x-show="sidebarOpen" 
                 x-transition:enter="transition-opacity ease-linear duration-300" 
                 x-transition:enter-start="opacity-0" 
                 x-transition:enter-end="opacity-100" 
                 x-transition:leave="transition-opacity ease-linear duration-300" 
                 x-transition:leave-start="opacity-100" 
                 x-transition:leave-end="opacity-0" 
                 class="fixed inset-0 bg-slate-900/80 backdrop-blur-sm" 
                 @click="sidebarOpen = false"></div>

            <div x-show="sidebarOpen" 
                 x-transition:enter="transition ease-in-out duration-300 transform" 
                 x-transition:enter-start="-translate-x-full" 
                 x-transition:enter-end="translate-x-0" 
                 x-transition:leave="transition ease-in-out duration-300 transform" 
                 x-transition:leave-start="translate-x-0" 
                 x-transition:leave-end="-translate-x-full" 
                 class="relative flex w-full max-w-xs flex-1 flex-col bg-white pt-5 pb-4">
                
                <div class="absolute top-0 right-0 -mr-12 pt-2">
                    <button type="button" 
                            class="ml-1 flex h-10 w-10 items-center justify-center rounded-full focus:outline-none focus:ring-2 focus:ring-inset focus:ring-white" 
                            @click="sidebarOpen = false">
                        <span class="sr-only">Close sidebar</span>
                        <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <div class="flex shrink-0 items-center px-6">
                    <div class="flex items-center gap-2">
                        <div class="w-10 h-10 bg-primary rounded-xl flex items-center justify-center shadow-lg shadow-primary/20">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                            </svg>
                        </div>
                        <span class="text-2xl font-bold text-slate-800">Uni<span class="text-primary">Quest</span></span>
                    </div>
                </div>
                <div class="mt-8 h-0 flex-1 overflow-y-auto px-4">
                    <nav class="space-y-2">
                        <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'bg-primary text-white' : 'text-slate-600 hover:bg-slate-50 hover:text-primary' }} group flex items-center px-4 py-3 text-sm font-semibold rounded-xl transition-all duration-200">
                            <svg class="mr-3 h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                            </svg>
                            Dashboard
                        </a>
                        <a href="#" class="text-slate-600 hover:bg-slate-50 hover:text-primary group flex items-center px-4 py-3 text-sm font-semibold rounded-xl transition-all duration-200">
                            <svg class="mr-3 h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            Quests
                        </a>
                        <a href="#" class="text-slate-600 hover:bg-slate-50 hover:text-primary group flex items-center px-4 py-3 text-sm font-semibold rounded-xl transition-all duration-200">
                            <svg class="mr-3 h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                            </svg>
                            Leaderboard
                        </a>
                        <a href="#" class="text-slate-600 hover:bg-slate-50 hover:text-primary group flex items-center px-4 py-3 text-sm font-semibold rounded-xl transition-all duration-200">
                            <svg class="mr-3 h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v13m0-13V6a2 2 0 112 2h-2zm0 0V5.5A2.5 2.5 0 109.5 8H12zm-7 4h14M5 12a2 2 0 110-4h14a2 2 0 110 4M5 12v7a2 2 0 002 2h10a2 2 0 002-2v-7" />
                            </svg>
                            Rewards
                        </a>
                    </nav>
                </div>
                <div class="mt-auto border-t border-slate-100 p-4">
                    <div class="flex items-center justify-between gap-3 px-2 py-3 rounded-xl bg-slate-50">
                        <div class="flex items-center gap-2 overflow-hidden">
                            <img src="https://api.dicebear.com/7.x/avataaars/svg?seed=Felix" alt="User" class="w-10 h-10 shrink-0 rounded-full border-2 border-primary/20">
                            <div class="min-w-0">
                                <p class="text-sm font-bold text-slate-800 truncate">{{ auth()->user()->name ?? 'Guest' }}</p>
                                <p class="text-xs text-slate-500 truncate">{{ auth()->user()->email ?? 'guest@univ.ac.id' }}</p>
                            </div>
                        </div>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="p-2 text-slate-400 hover:text-red-500 transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                </svg>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Desktop Sidebar -->
        <div class="hidden md:flex md:w-72 md:flex-col md:fixed md:inset-y-0 z-10">
            <div class="flex grow flex-col overflow-y-auto border-r border-slate-100 bg-white pt-8 pb-4">
                <div class="flex items-center gap-3 px-8 mb-10">
                    <div class="w-11 h-11 bg-primary rounded-2xl flex items-center justify-center shadow-xl shadow-primary/20 transform rotate-3 hover:rotate-0 transition-transform duration-300">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                        </svg>
                    </div>
                    <div>
                        <span class="text-2xl font-black text-slate-800 tracking-tight">Uni<span class="text-primary italic">Quest</span></span>
                        <div class="h-1 w-12 bg-primary/30 rounded-full mt-[-2px]"></div>
                    </div>
                </div>
                
                <div class="flex-1 space-y-8 px-6">
                    <nav class="space-y-1">
                        <div class="px-2 mb-2">
                            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Main Hub</p>
                        </div>
                        <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'bg-primary/10 text-primary shadow-xs' : 'text-slate-500 hover:bg-slate-50 hover:text-primary' }} group flex items-center px-4 py-3.5 text-sm font-bold rounded-2xl transition-all duration-300">
                            <div class="w-8 h-8 rounded-lg flex items-center justify-center mr-3 {{ request()->routeIs('dashboard') ? 'bg-primary text-white shadow-lg shadow-primary/30' : 'bg-slate-100 text-slate-400' }} group-hover:scale-110 transition-transform">
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                                </svg>
                            </div>
                            Dashboard
                        </a>
                        <a href="#" class="text-slate-500 hover:bg-slate-50 hover:text-primary group flex items-center px-4 py-3.5 text-sm font-bold rounded-2xl transition-all duration-300">
                            <div class="w-8 h-8 rounded-lg flex items-center justify-center mr-3 bg-slate-100 text-slate-400 group-hover:bg-primary group-hover:text-white transition-all">
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7" />
                                </svg>
                            </div>
                            Quest Management
                        </a>
                        <a href="#" class="text-slate-500 hover:bg-slate-50 hover:text-primary group flex items-center px-4 py-3.5 text-sm font-bold rounded-2xl transition-all duration-300">
                            <div class="w-8 h-8 rounded-lg flex items-center justify-center mr-3 bg-slate-100 text-slate-400 group-hover:bg-primary group-hover:text-white transition-all">
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                                </svg>
                            </div>
                            Leaderboard
                        </a>
                        <a href="#" class="text-slate-500 hover:bg-slate-50 hover:text-primary group flex items-center px-4 py-3.5 text-sm font-bold rounded-2xl transition-all duration-300">
                            <div class="w-8 h-8 rounded-lg flex items-center justify-center mr-3 bg-slate-100 text-slate-400 group-hover:bg-primary group-hover:text-white transition-all">
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z" />
                                </svg>
                            </div>
                            Campus Insight
                        </a>
                    </nav>

                    <nav class="space-y-1">
                        <div class="px-2 mb-2">
                            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Player & Guilds</p>
                        </div>
                        <a href="{{ route('students') }}" class="text-slate-500 hover:bg-slate-50 hover:text-primary group flex items-center px-4 py-3.5 text-sm font-bold rounded-2xl transition-all duration-300">
                             <div class="w-8 h-8 rounded-lg flex items-center justify-center mr-3 bg-slate-100 text-slate-400 group-hover:bg-primary group-hover:text-white transition-all">
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 14l9-5-9-5-9 5 9 5z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z" />
                                </svg>
                            </div>
                            Students
                        </a>
                        <a href="#" class="text-slate-500 hover:bg-slate-50 hover:text-primary group flex items-center px-4 py-3.5 text-sm font-bold rounded-2xl transition-all duration-300">
                             <div class="w-8 h-8 rounded-lg flex items-center justify-center mr-3 bg-slate-100 text-slate-400 group-hover:bg-primary group-hover:text-white transition-all">
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                </svg>
                            </div>
                            Organizations
                        </a>
                        <a href="#" class="text-slate-500 hover:bg-slate-50 hover:text-primary group flex items-center px-4 py-3.5 text-sm font-bold rounded-2xl transition-all duration-300">
                             <div class="w-8 h-8 rounded-lg flex items-center justify-center mr-3 bg-slate-100 text-slate-400 group-hover:bg-primary group-hover:text-white transition-all">
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z" />
                                </svg>
                            </div>
                            Skills Master
                        </a>
                        <a href="#" class="text-slate-500 hover:bg-slate-50 hover:text-primary group flex items-center px-4 py-3.5 text-sm font-bold rounded-2xl transition-all duration-300">
                             <div class="w-8 h-8 rounded-lg flex items-center justify-center mr-3 bg-slate-100 text-slate-400 group-hover:bg-primary group-hover:text-white transition-all">
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.54 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.784.57-1.838-.196-1.539-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                                </svg>
                            </div>
                            Achievements
                        </a>
                    </nav>

                    <nav class="space-y-1">
                        <div class="px-2 mb-2">
                            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Economy & Vault</p>
                        </div>
                        <a href="#" class="text-slate-500 hover:bg-slate-50 hover:text-primary group flex items-center px-4 py-3.5 text-sm font-bold rounded-2xl transition-all duration-300">
                             <div class="w-8 h-8 rounded-lg flex items-center justify-center mr-3 bg-slate-100 text-slate-400 group-hover:bg-primary group-hover:text-white transition-all">
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                                </svg>
                            </div>
                            Point Shop
                        </a>
                        <a href="#" class="text-slate-500 hover:bg-slate-50 hover:text-primary group flex items-center px-4 py-3.5 text-sm font-bold rounded-2xl transition-all duration-300">
                             <div class="w-8 h-8 rounded-lg flex items-center justify-center mr-3 bg-slate-100 text-slate-400 group-hover:bg-primary group-hover:text-white transition-all">
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A3.323 3.323 0 0010.65 15c-1.838 0-3.33 1.492-3.33 3.331V21h10.681v-2.669c0-1.838-1.492-3.331-3.33-3.331a3.323 3.323 0 00-4.07 2.669m-.333-8.669c0-1.838 1.492-3.331 3.33-3.331a3.323 3.323 0 013.331 3.331c0 1.838-1.492 3.331-3.331 3.331a3.323 3.323 0 01-3.33-3.331z" />
                                </svg>
                            </div>
                            Verification Center
                        </a>
                    </nav>

                    <nav class="space-y-1">
                        <div class="px-2 mb-2">
                            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">System Admin</p>
                        </div>
                        <a href="{{ route('users') }}" class="text-slate-500 hover:bg-slate-50 hover:text-primary group flex items-center px-4 py-3.5 text-sm font-bold rounded-2xl transition-all duration-300">
                             <div class="w-8 h-8 rounded-lg flex items-center justify-center mr-3 bg-slate-100 text-slate-400 group-hover:bg-primary group-hover:text-white transition-all">
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                            </div>
                            Users
                        </a>
                        <a href="#" class="text-slate-500 hover:bg-slate-50 hover:text-primary group flex items-center px-4 py-3.5 text-sm font-bold rounded-2xl transition-all duration-300">
                             <div class="w-8 h-8 rounded-lg flex items-center justify-center mr-3 bg-slate-100 text-slate-400 group-hover:bg-primary group-hover:text-white transition-all">
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z" />
                                </svg>
                            </div>
                            Roles & Access
                        </a>
                    </nav>

                    {{-- <nav class="space-y-1">
                        <div class="px-2 mb-2">
                            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Growth</p>
                        </div>
                        <a href="#" class="text-slate-500 hover:bg-slate-50 hover:text-primary group flex items-center px-4 py-3.5 text-sm font-bold rounded-2xl transition-all duration-300">
                             <div class="w-8 h-8 rounded-lg flex items-center justify-center mr-3 bg-slate-100 text-slate-400 group-hover:bg-primary group-hover:text-white transition-all">
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v13m0-13V6a2 2 0 112 2h-2zm0 0V5.5A2.5 2.5 0 109.5 8H12zm-7 4h14M5 12a2 2 0 110-4h14a2 2 0 110 4M5 12v7a2 2 0 002 2h10a2 2 0 002-2v-7" />
                                </svg>
                            </div>
                            Rewards
                        </a>
                        <a href="#" class="text-slate-500 hover:bg-slate-50 hover:text-primary group flex items-center px-4 py-3.5 text-sm font-bold rounded-2xl transition-all duration-300">
                             <div class="w-8 h-8 rounded-lg flex items-center justify-center mr-3 bg-slate-100 text-slate-400 group-hover:bg-primary group-hover:text-white transition-all">
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                            </div>
                            Settings
                        </a>
                    </nav> --}}
                </div>

                <div class="mt-auto p-6 border-t border-slate-50">
                    <div class="bg-primary/5 rounded-3xl p-5 relative overflow-hidden group">
                        <div class="absolute -right-4 -bottom-4 w-24 h-24 bg-primary/10 rounded-full blur-2xl group-hover:scale-150 transition-transform duration-500"></div>
                        <div class="flex items-center gap-4 relative z-10">
                            <img src="https://api.dicebear.com/7.x/avataaars/svg?seed=Felix" alt="User" class="w-12 h-12 rounded-2xl border-2 border-white shadow-md">
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-bold text-slate-800 truncate">{{ auth()->user()->name ?? 'Super Admin' }}</p>
                                {{-- <p class="text-[10px] text-primary font-bold uppercase tracking-wider">Level 42 Hero</p> --}}
                            </div>
                        </div>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="mt-4 w-full py-2.5 bg-white border border-slate-100 text-slate-600 font-bold text-xs rounded-xl shadow-sm hover:shadow-md hover:text-red-500 transition-all flex items-center justify-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                </svg>
                                Log Out
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content Wrapper -->
        <div class="md:pl-72 flex flex-col flex-1 h-full overflow-hidden">
            <!-- Top Navbar -->
            <header class="h-20 bg-white/80 backdrop-blur-md border-b border-slate-100 sticky top-0 z-30 px-4 sm:px-8 flex items-center justify-between">
                <div class="flex items-center gap-4">
                    <button type="button" 
                            class="md:hidden p-2 text-slate-500 hover:text-primary transition-colors" 
                            @click="sidebarOpen = true">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7" />
                        </svg>
                    </button>
                    
                    <!-- Breadcrumbs -->
                    <nav class="flex text-sm font-medium" aria-label="Breadcrumb">
                        <ol class="flex items-center space-x-2">
                            <li>
                                <div class="flex items-center">
                                    <a href="#" class="text-slate-400 hover:text-primary transition-colors">
                                        <svg class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 20 20" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z" />
                                        </svg>
                                    </a>
                                </div>
                            </li>
                            @if(isset($breadcrumbs))
                                @foreach($breadcrumbs as $breadcrumb)
                                    <li>
                                        <div class="flex items-center">
                                            <svg class="h-5 w-5 shrink-0 text-slate-300" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" />
                                            </svg>
                                            <a href="{{ $breadcrumb['url'] }}" class="ml-2 text-slate-400 hover:text-slate-600 transition-colors">{{ $breadcrumb['label'] }}</a>
                                        </div>
                                    </li>
                                @endforeach
                            @endif
                            <li>
                                <div class="flex items-center">
                                    <svg class="h-5 w-5 shrink-0 text-slate-300" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" />
                                    </svg>
                                    <span class="ml-2 text-slate-800 font-bold" aria-current="page">{{ $title ?? 'Dashboard' }}</span>
                                </div>
                            </li>
                        </ol>
                    </nav>
                </div>

                <div class="flex items-center gap-5">
                    <!-- Notifications -->
                    <button class="p-2 relative text-slate-400 hover:text-primary transition-colors bg-slate-50 rounded-xl hover:shadow-sm">
                        <span class="absolute top-2 right-2 w-2 h-2 bg-red-500 rounded-full border-2 border-white ring-2 ring-red-500/20"></span>
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                        </svg>
                    </button>
                    
                    <!-- Search Trigger (Desktop) -->
                    <div class="hidden sm:block relative">
                         <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                             <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                         </div>
                         <input type="text" placeholder="Search quests..." class="pl-10 pr-4 py-2.5 bg-slate-50 border border-slate-100 rounded-xl text-xs font-bold text-slate-800 placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-primary/10 focus:border-primary transition-all w-64 shadow-sm">
                    </div>
                </div>
            </header>

            <!-- Main Scrollable Content Area -->
            <main class="flex-1 overflow-y-auto bg-slate-50 scroll-smooth">
                <div class="py-8 px-4 sm:px-8 max-w-7xl mx-auto">
                    <!-- Dynamic Tooltip or Alert Area (Optional) -->
                    @if(session('status'))
                        <div class="mb-6 p-4 bg-green-50 border-l-4 border-green-500 rounded-r-xl flex items-center gap-3 animate-in fade-in slide-in-from-top duration-500">
                            <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <p class="text-sm font-bold text-green-800">{{ session('status') }}</p>
                        </div>
                    @endif

                    {{ $slot }}
                </div>
                
                <!-- Footer -->
                <footer class="mt-auto py-8 px-8 border-t border-slate-200/60 flex flex-col sm:flex-row justify-between items-center gap-4 text-slate-400 text-xs font-medium">
                    <p>© {{ date('Y') }} UniQuest Academy. All rights reserved.</p>
                    <div class="flex gap-6">
                        <a href="#" class="hover:text-primary transition-colors">Documentation</a>
                        <a href="#" class="hover:text-primary transition-colors">Privacy Policy</a>
                        <a href="#" class="hover:text-primary transition-colors">Support</a>
                    </div>
                </footer>
            </main>
        </div>
    </div>

    @livewireScripts
</body>
</html>
