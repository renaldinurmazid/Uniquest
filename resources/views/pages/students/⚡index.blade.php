<?php

use App\Models\User;
use App\Models\StudentProfile;
use App\Models\Role;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

new #[Layout('layouts::app')] #[Title('Students Analytics')] class extends Component {
    use WithPagination;

    public $search = '';

    // Form fields
    public $name = '';
    public $email = '';
    public $npm = '';
    public $password = '';

    protected $rules = [
        'name' => 'required|min:3',
        'email' => 'required|email|unique:users,email',
        'npm' => 'required|unique:student_profiles,npm',
        'password' => 'required|min:6',
    ];

    public function getStudents()
    {
        return User::whereHas('roles', fn($q) => $q->where('name', 'student'))
            ->with(['studentProfile', 'skills'])
            ->where(function($q) {
                $q->where('name', 'like', '%' . $this->search . '%')
                  ->orWhereHas('studentProfile', fn($sp) => $sp->where('npm', 'like', '%' . $this->search . '%'));
            })
            ->latest()
            ->paginate(12);
    }

    public function createStudent()
    {
        try {
            $validated = $this->validate();

            DB::transaction(function () use ($validated) {
                $user = User::create([
                    'name' => $this->name,
                    'email' => $this->email,
                    'password' => Hash::make($this->password),
                ]);

                $user->assignRole('student');
                // Create profile
                StudentProfile::create([
                    'user_id' => $user->id,
                    'npm' => $this->npm,
                    'level' => 1,
                    'current_exp' => 0,
                    'total_coins' => 0,
                ]);
            });

            $this->reset(['name', 'email', 'npm', 'password']);
            $this->dispatch('close-modal');
            session()->flash('status', 'New hero enrolled successfully!');
        } catch (\Exception $e) {
            session()->flash('error', 'Critical Error: ' . $e->getMessage());
        }
    }
}; ?>

<div x-data="{ showModal: false }" @close-modal.window="showModal = false" class="space-y-8">
    @if(session('error'))
        <div class="p-4 bg-red-50 text-red-600 rounded-2xl border border-red-100 font-bold mb-4">
            {{ session('error') }}
        </div>
    @endif
    <div class="flex sm:row justify-between items-start sm:items-center gap-4">
        <div>
            <h1 class="text-3xl font-black text-slate-800 tracking-tight">Student Analytics</h1>
            <p class="text-slate-500 font-medium">Monitor player progression and academy activity across all guilds.</p>
        </div>
        <button @click="showModal = true" class="px-8 py-4 bg-primary text-white font-black rounded-3xl shadow-xl shadow-primary/30 hover:shadow-primary/50 transform transition-all active:scale-95 duration-200 flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
            </svg>
            Enroll New Hero
        </button>
    </div>

    <!-- Quick Stats Hub -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-xs space-y-2">
            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Active Guardians</p>
            <h3 class="text-3xl font-black text-slate-800">{{ User::whereHas('roles', fn($q) => $q->where('name', 'student'))->count() }}</h3>
            <p class="text-[10px] font-bold text-green-500 flex items-center gap-1">+14% Growth</p>
        </div>
        <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-xs space-y-2">
            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Avg. Level</p>
            <h3 class="text-3xl font-black text-slate-800">{{ number_format(StudentProfile::avg('level') ?: 1, 1) }}</h3>
            <p class="text-[10px] font-bold text-blue-500 flex items-center gap-1">Top Tier 34%</p>
        </div>
        <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-xs space-y-2">
            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Total EXP</p>
            <h3 class="text-3xl font-black text-slate-800">142.1k</h3>
            <p class="text-[10px] font-bold text-green-500 flex items-center gap-1">+2.4k Today</p>
        </div>
        <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-xs space-y-2">
            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Guild Participation</p>
            <h3 class="text-3xl font-black text-slate-800">88%</h3>
            <p class="text-[10px] font-bold text-amber-500 flex items-center gap-1">Stable</p>
        </div>
    </div>

    <!-- Search Tool -->
    <div class="relative group">
        <div class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none text-slate-400 group-focus-within:text-primary transition-colors">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
            </svg>
        </div>
        <input wire:model.live.debounce.300ms="search" type="text" placeholder="Search by student name, ID, or guild..." class="w-full pl-14 pr-5 py-5 bg-white border-2 border-slate-50 rounded-3xl text-sm font-bold text-slate-800 placeholder:text-slate-300 focus:outline-none focus:ring-8 focus:ring-primary/5 focus:border-primary transition-all shadow-xs">
    </div>

    <!-- Student Census Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
        @forelse($this->getStudents() as $student)
            <div class="bg-white rounded-[32px] border border-slate-100 shadow-xs hover:shadow-2xl hover:-translate-y-2 transition-all duration-300 group overflow-hidden">
                <div class="p-6 space-y-6">
                    <div class="flex justify-between items-start">
                        <div class="flex items-center gap-4">
                            <div class="relative">
                                <img src="https://api.dicebear.com/7.x/avataaars/svg?seed={{ $student->email }}&backgroundColor=b6e3f4" class="w-16 h-16 rounded-2xl border-4 border-white shadow-xl">
                                <div class="absolute -bottom-1 -right-1 w-7 h-7 bg-primary text-white text-[11px] font-black rounded-xl flex items-center justify-center border-4 border-white shadow-lg">
                                    {{ $student->studentProfile?->level ?? 1 }}
                                </div>
                            </div>
                            <div class="min-w-0">
                                <h3 class="text-sm font-black text-slate-800 truncate group-hover:text-primary transition-colors">{{ $student->name }}</h3>
                                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mt-0.5">{{ $student->studentProfile?->npm ?? 'N/A' }}</p>
                            </div>
                        </div>
                        <button class="p-2 text-slate-300 hover:text-red-500 hover:bg-red-50 rounded-xl transition-all">
                             <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                        </button>
                    </div>

                    <!-- Visual Progress Bar -->
                    <div class="space-y-2">
                        <div class="flex justify-between items-end">
                            <span class="text-[10px] font-black text-slate-400 uppercase">EXP Progression</span>
                            <span class="text-[11px] font-black text-blue-600">{{ $student->studentProfile?->current_exp ?? 0 }} / 5000</span>
                        </div>
                        <div class="w-full h-2 bg-slate-50 rounded-full overflow-hidden p-0.5 ring-1 ring-slate-100">
                             <div class="h-full bg-linear-to-r from-blue-500 to-primary rounded-full" style="width: {{ min(($student->studentProfile?->current_exp ?? 0) / 5000 * 100, 100) }}%"></div>
                        </div>
                    </div>

                    <!-- Mini Traits / Skills -->
                    <div class="grid grid-cols-3 gap-2">
                        @foreach($student->skills->take(3) as $skill)
                            <div class="p-2 bg-slate-50 rounded-xl text-center">
                                <p class="text-[8px] font-black text-slate-400 uppercase truncate">{{ $skill->name }}</p>
                                <p class="text-xs font-black text-slate-700 mt-1">{{ $skill->pivot->points }}</p>
                            </div>
                        @endforeach
                        @if($student->skills->isEmpty())
                            @foreach(['STR', 'INT', 'AGI'] as $trait)
                                <div class="p-2 bg-slate-50 rounded-xl text-center">
                                    <p class="text-[8px] font-black text-slate-400 uppercase">{{ $trait }}</p>
                                    <p class="text-xs font-black text-slate-300 mt-1">0</p>
                                </div>
                            @endforeach
                        @endif
                    </div>

                    <div class="pt-6 border-t border-slate-50 flex items-center justify-between">
                        <div class="flex items-center gap-1.5 font-black text-slate-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            <span class="text-[10px] uppercase">G. Majapahit</span>
                        </div>
                        <a href="#" class="px-4 py-2 bg-slate-900 text-white text-[10px] font-black uppercase tracking-widest rounded-xl hover:bg-primary transition-all">Inspect Card</a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full py-40 flex flex-col items-center justify-center space-y-6">
                <img src="{{ asset('assets/svg/no_data.svg') }}" class="w-64 opacity-50">
                <p class="text-slate-400 font-bold">No heroes found. The academy is waiting for new enrollments.</p>
            </div>
        @endforelse
    </div>

    <!-- Paging -->
    <div class="py-10">
        {{ $this->getStudents()->links() }}
    </div>

    <!-- Create Student Modal -->
    <div x-show="showModal" 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 z-50 flex items-center justify-center p-4" x-cloak>
        <div @click="showModal = false" class="absolute inset-0 bg-slate-900/60 backdrop-blur-xl"></div>
        <div class="relative bg-white w-full max-w-xl rounded-[40px] shadow-2xl overflow-hidden"
             x-show="showModal"
             x-transition:enter="transition ease-out duration-300 transform"
             x-transition:enter-start="scale-95 opacity-0"
             x-transition:enter-end="scale-100 opacity-100"
             x-transition:leave="transition ease-in duration-200 transform"
             x-transition:leave-start="scale-100 opacity-100"
             x-transition:leave-end="scale-95 opacity-0">
            <div class="p-10 space-y-8">
                <div>
                    <h2 class="text-2xl font-black text-slate-800">Enroll New Guardian</h2>
                    <p class="text-slate-400 font-medium">Create a new student identity and system account.</p>
                </div>

                <form wire:submit="createStudent" class="space-y-6">
                    <div class="grid grid-cols-2 gap-6">
                        <div class="space-y-2">
                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Full Name</label>
                            <input wire:model="name" type="text" class="w-full px-5 py-4 bg-slate-50 border-none rounded-2xl text-sm font-bold text-slate-800 placeholder:text-slate-300 focus:ring-4 focus:ring-primary/5 transition-all">
                            @error('name') <span class="text-[10px] font-bold text-red-500 ml-1">{{ $message }}</span> @enderror
                        </div>
                        <div class="space-y-2">
                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Student ID (NPM)</label>
                            <input wire:model="npm" type="text" class="w-full px-5 py-4 bg-slate-50 border-none rounded-2xl text-sm font-bold text-slate-800 placeholder:text-slate-300 focus:ring-4 focus:ring-primary/5 transition-all">
                            @error('npm') <span class="text-[10px] font-bold text-red-500 ml-1">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Academy Email</label>
                        <input wire:model="email" type="email" class="w-full px-5 py-4 bg-slate-50 border-none rounded-2xl text-sm font-bold text-slate-800 placeholder:text-slate-300 focus:ring-4 focus:ring-primary/5 transition-all">
                        @error('email') <span class="text-[10px] font-bold text-red-500 ml-1">{{ $message }}</span> @enderror
                    </div>

                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Secure Password</label>
                        <input wire:model="password" type="password" class="w-full px-5 py-4 bg-slate-50 border-none rounded-2xl text-sm font-bold text-slate-800 placeholder:text-slate-300 focus:ring-4 focus:ring-primary/5 transition-all">
                        @error('password') <span class="text-[10px] font-bold text-red-500 ml-1">{{ $message }}</span> @enderror
                    </div>

                    <div class="pt-4 flex gap-4">
                        <button type="button" @click="showModal = false" class="flex-1 py-4 text-slate-400 font-black text-xs uppercase tracking-widest rounded-3xl hover:bg-slate-50 transition-all">Cancel</button>
                        <button type="submit" class="flex-2 py-4 bg-primary text-white font-black text-xs uppercase tracking-widest rounded-3xl shadow-xl shadow-primary/30 active:scale-95 transition-all outline-none">Initiate Student</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>