<?php

use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Computed;

new #[Layout('layouts::auth', ['title' => 'Login'])] class extends Component {
    #[Computed]
    public $email;
    public $password;

    public function login()
    {
        $this->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($this->only(['email', 'password']))) {
            return redirect()->intended('dashboard');
        }

        session()->flash('error', 'Invalid credentials');
    }
};
?>

<div class="space-y-8 animate-in fade-in slide-in-from-bottom-4 duration-700">
    <div class="space-y-2">
        <h1 class="text-4xl font-extrabold tracking-tight text-gray-900">Welcome Back</h1>
        <p class="text-gray-500 text-lg">Sign in to continue your adventure.</p>
    </div>

    <div class="space-y-4">
        <form wire:submit="login" class="space-y-6">
            <div class="space-y-4">
                <div class="space-y-1.5 focus-within:text-primary transition-colors">
                    <label for="email" class="text-sm font-semibold text-gray-700 ml-1">Email Address</label>
                    <div class="relative group">
                        <div
                            class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none group-focus-within:text-primary text-gray-400 transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.206" />
                            </svg>
                        </div>
                        <input type="email" id="email" wire:model="email"
                            class="w-full pl-11 pr-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:outline-hidden focus:ring-4 focus:ring-primary/10 focus:border-primary transition-all text-gray-900 placeholder:text-gray-400"
                            placeholder="name@university.edu" required>
                    </div>
                </div>

                <div class="space-y-1.5 focus-within:text-primary transition-colors">
                    <div class="flex justify-between items-center ml-1">
                        <label for="password" class="text-sm font-semibold text-gray-700">Password</label>
                        <a href="#"
                            class="text-xs font-bold text-primary hover:text-primary/80 transition-colors">Forgot?</a>
                    </div>
                    <div class="relative group">
                        <div
                            class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none group-focus-within:text-primary text-gray-400 transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                            </svg>
                        </div>
                        <input type="password" id="password" wire:model="password"
                            class="w-full pl-11 pr-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:outline-hidden focus:ring-4 focus:ring-primary/10 focus:border-primary transition-all text-gray-900 placeholder:text-gray-400"
                            placeholder="••••••••" required>
                    </div>
                </div>
            </div>

            <div class="flex items-center gap-3 ml-1">
                <input type="checkbox" id="remember"
                    class="w-4 h-4 rounded-sm border-gray-300 text-blue-600 focus:ring-blue-500 cursor-pointer">
                <label for="remember" class="text-sm font-medium text-gray-600 cursor-pointer select-none">Remember me
                    for 30 days</label>
            </div>

            <button type="submit"
                class="w-full py-4 bg-primary hover:bg-primary/80 text-white font-bold rounded-xl shadow-lg shadow-primary/30 hover:shadow-primary/40 transform transition-all active:scale-[0.98] duration-200 flex items-center justify-center gap-2 group">
                Sign In
            </button>
        </form>
    </div>
</div>
