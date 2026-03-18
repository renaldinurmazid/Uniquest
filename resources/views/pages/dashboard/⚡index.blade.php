<?php

use Livewire\Component;
use Livewire\Attributes\Layout;

new #[Layout('layouts::app', ['title' => 'Dashboard'])] class extends Component
{
    //
};
?>

<div class="space-y-8 animate-in fade-in duration-700">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
        <div>
            <h1 class="text-3xl font-bold text-slate-900 tracking-tight">Welcome back, Hero!</h1>
            <p class="text-slate-500 mt-2 font-medium">Here's what's happening on your campus quest today.</p>
        </div>
        <div class="flex items-center gap-3">
            <button class="px-5 py-3 bg-white border border-slate-200 text-slate-700 font-bold text-sm rounded-2xl shadow-sm hover:shadow-md hover:border-primary/20 transition-all flex items-center gap-2">
                <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                Export Stats
            </button>
            <button class="px-5 py-3 bg-primary text-white font-bold text-sm rounded-2xl shadow-lg shadow-primary/30 hover:shadow-primary/40 transform hover:-translate-y-0.5 active:scale-95 transition-all flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                New Quest
            </button>
        </div>
    </div>

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm hover:shadow-md transition-shadow group">
            <div class="flex items-center justify-between mb-4">
                <div class="p-3 bg-blue-50 text-blue-600 rounded-2xl transition-transform group-hover:scale-110">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                </div>
                <span class="text-xs font-bold text-green-500 bg-green-50 px-2 py-1 rounded-full">+12%</span>
            </div>
            <p class="text-slate-500 text-sm font-bold uppercase tracking-wider">Total Players</p>
            <h3 class="text-2xl font-black text-slate-800 mt-1">2,482</h3>
        </div>

        <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm hover:shadow-md transition-shadow group">
            <div class="flex items-center justify-between mb-4">
                <div class="p-3 bg-primary/10 text-primary rounded-2xl transition-transform group-hover:scale-110">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                    </svg>
                </div>
                <span class="text-xs font-bold text-primary bg-primary/10 px-2 py-1 rounded-full">+5.4%</span>
            </div>
            <p class="text-slate-500 text-sm font-bold uppercase tracking-wider">Active Quests</p>
            <h3 class="text-2xl font-black text-slate-800 mt-1">156</h3>
        </div>

        <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm hover:shadow-md transition-shadow group">
            <div class="flex items-center justify-between mb-4">
                <div class="p-3 bg-yellow-50 text-yellow-600 rounded-2xl transition-transform group-hover:scale-110">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <span class="text-xs font-bold text-red-500 bg-red-50 px-2 py-1 rounded-full">-2%</span>
            </div>
            <p class="text-slate-500 text-sm font-bold uppercase tracking-wider">Total Rewards</p>
            <h3 class="text-2xl font-black text-slate-800 mt-1">₿ 42.5k</h3>
        </div>

        <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm hover:shadow-md transition-shadow group">
            <div class="flex items-center justify-between mb-4">
                <div class="p-3 bg-purple-50 text-purple-600 rounded-2xl transition-transform group-hover:scale-110">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z" />
                    </svg>
                </div>
                <span class="text-xs font-bold text-purple-500 bg-purple-50 px-2 py-1 rounded-full">HOT</span>
            </div>
            <p class="text-slate-500 text-sm font-bold uppercase tracking-wider">Completed</p>
            <h3 class="text-2xl font-black text-slate-800 mt-1">89%</h3>
        </div>
    </div>

    <!-- Recent Activity Placeholder -->
    <div class="bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden">
        <div class="px-8 py-6 border-b border-slate-50 flex items-center justify-between">
            <h2 class="text-lg font-bold text-slate-900">Recent Quest Activity</h2>
            <a href="#" class="text-sm font-bold text-primary hover:underline">View All</a>
        </div>
        <div class="divide-y divide-slate-50">
            @foreach(['Alex Johnson completed "Library Explorer"', 'Sarah Miller earned "Early Bird" badge', 'Marcus Wong joined the "Coding Marathon" quest'] as $activity)
                <div class="px-8 py-5 flex items-center justify-between hover:bg-slate-50 transition-colors group">
                    <div class="flex items-center gap-4">
                        <div class="w-10 h-10 rounded-full bg-slate-100 flex items-center justify-center text-slate-400 group-hover:bg-primary group-hover:text-white transition-all">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm font-bold text-slate-800">{{ $activity }}</p>
                            <p class="text-xs text-slate-400">2 hours ago</p>
                        </div>
                    </div>
                    <svg class="w-5 h-5 text-slate-300 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </div>
            @endforeach
        </div>
    </div>
</div>