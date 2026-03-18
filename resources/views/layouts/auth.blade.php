<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ config('app.name') }} - {{ $title ?? 'App' }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @livewireStyles
</head>

<body class="antialiased bg-gray-50">
    <div class="min-h-screen flex items-center justify-center p-4 sm:p-6 lg:p-8">
        <div
            class="max-w-6xl w-full bg-white rounded-3xl shadow-2xl overflow-hidden flex flex-col md:flex-row min-h-[600px]">
            <!-- Left Side: Branding/Image -->
            <div
                class="md:w-1/2 bg-white p-12 flex flex-col justify-center items-center relative overflow-hidden">
                <div class="relative z-10 w-full max-w-md transform hover:scale-105 transition-transform duration-500">
                    <img src="{{ asset('assets/svg/man_reward.svg') }}" alt="UniQuest Login Illustration"
                        class="w-full h-auto drop-shadow-2xl">
                </div>
                <div class="mt-8 text-center relative z-10">
                    <h2 class="text-3xl font-bold text-primary mb-2">Level Up Your Campus Life</h2>
                    <p class="text-slate-800 text-lg opacity-90">Join the quest, earn rewards, and build your digital
                        legacy at UniQuest.</p>
                </div>
            </div>

            <!-- Right Side: Content -->
            <div class="md:w-1/2 p-8 sm:p-12 md:p-16 flex flex-col justify-center bg-white">
                <div class="w-full max-w-md mx-auto">
                    {{ $slot }}
                </div>
            </div>
        </div>
    </div>
    @livewireScripts
</body>

</html>
