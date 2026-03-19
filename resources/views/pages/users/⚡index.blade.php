<?php

use App\Models\User;
use App\Models\Role;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Illuminate\Support\Facades\Hash;

new #[Layout('layouts::app')] #[Title('System Users')] class extends Component {
    use WithPagination;

    public $search = '';

    // Form fields
    public $name = '';
    public $email = '';
    public $role_id = '';
    public $password = '';

    protected $rules = [
        'name' => 'required|min:3',
        'email' => 'required|email|unique:users,email',
        'role_id' => 'required|exists:roles,id',
        'password' => 'required|min:6',
    ];

    public function getUsers()
    {
        // System users are typically not 'user' (students)
        return User::whereHas('roles', fn($q) => $q->whereIn('name', ['admin', 'superadmin', 'staff']))
            ->with('roles')
            ->where('name', 'like', '%' . $this->search . '%')
            ->latest()
            ->paginate(15);
    }

    public function createUser()
    {
        try {
            $this->validate();

            $user = User::create([
                'name' => $this->name,
                'email' => $this->email,
                'password' => Hash::make($this->password),
            ]);

            $role = Role::find($this->role_id);
            if ($role) {
                $user->assignRole($role->name);
            }

            $this->reset(['name', 'email', 'role_id', 'password']);
            $this->dispatch('close-modal');
            session()->flash('status', 'System access granted to ' . $user->name);
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
            <h1 class="text-3xl font-black text-slate-800 tracking-tight">System Users</h1>
            <p class="text-slate-500 font-medium">Control access and authority levels for admins and staff.</p>
        </div>
        <button @click="showModal = true" class="px-8 py-4 bg-primary text-white font-black rounded-3xl shadow-xl shadow-primary/30 hover:shadow-primary/50 transform transition-all active:scale-95 duration-200 flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
            </svg>
            Grant System Access
        </button>
    </div>

    <!-- User Table Card -->
    <div class="bg-white rounded-[40px] border border-slate-100 shadow-xs overflow-hidden min-h-[60vh]">
        <div class="p-8 border-b border-slate-50 flex md:row justify-between items-center gap-4">
            <div class="relative w-full md:w-96">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>
                <input wire:model.live.debounce.300ms="search" type="text" placeholder="Search staff by name or email..." class="w-full pl-11 pr-4 py-4 bg-slate-50 border-none rounded-2xl text-sm font-bold text-slate-800 placeholder:text-slate-300 focus:outline-none focus:ring-4 focus:ring-primary/5 transition-all">
            </div>
            <div class="flex items-center gap-3">
                <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest px-4">{{ $this->getUsers()->total() }} Staff Active</span>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead class="bg-slate-50/50">
                    <tr>
                        <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest">Vault ID</th>
                        <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest">Master Identity</th>
                        <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest">Authority Level</th>
                        <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest text-right">Vault Key</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($this->getUsers() as $user)
                        <tr class="hover:bg-slate-50 transition-colors group">
                            <td class="px-8 py-6">
                                <span class="text-[10px] font-black text-slate-300 uppercase tracking-tighter">#{{ substr($user->id, 0, 8) }}</span>
                            </td>
                            <td class="px-8 py-6">
                                <div class="flex items-center gap-4">
                                    <div class="w-12 h-12 bg-linear-to-br from-slate-100 to-white rounded-2xl flex items-center justify-center border-2 border-white shadow-xs group-hover:scale-110 transition-transform">
                                        <img src="https://api.dicebear.com/7.x/bottts/svg?seed={{ $user->email }}&backgroundColor=f8fafc" class="w-8 h-8 opacity-80 group-hover:opacity-100">
                                    </div>
                                    <div class="min-w-0">
                                        <p class="text-sm font-black text-slate-800 group-hover:text-primary transition-colors">{{ $user->name }}</p>
                                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">{{ $user->email }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-8 py-6">
                                <div class="flex flex-wrap gap-2">
                                    @foreach($user->roles as $role)
                                        <span class="inline-flex items-center px-3 py-1 bg-primary/5 text-primary text-[10px] font-black uppercase tracking-widest rounded-lg border border-primary/10">
                                            {{ $role->name }}
                                        </span>
                                    @endforeach
                                    @if($user->roles->isEmpty())
                                        <span class="text-[10px] font-black text-slate-300 italic">No Access Assigned</span>
                                    @endif
                                </div>
                            </td>
                            <td class="px-8 py-6 text-right">
                                <div class="flex justify-end gap-2">
                                    <button class="p-2.5 text-slate-400 hover:text-primary hover:bg-primary/5 rounded-xl transition-all" title="Manage Permissions">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z" />
                                        </svg>
                                    </button>
                                    <button class="p-2.5 text-slate-400 hover:text-red-500 hover:bg-red-50 rounded-xl transition-all" title="Decommission Account">
                                         <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="py-40 text-center">
                                <img src="{{ asset('assets/svg/no_data.svg') }}" class="w-64 mx-auto opacity-50 mb-6">
                                <p class="text-slate-300 font-bold uppercase tracking-widest">No master accounts found.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="p-8 bg-slate-50/50">
            {{ $this->getUsers()->links() }}
        </div>
    </div>

    <!-- Create User Modal -->
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
                    <h2 class="text-2xl font-black text-slate-800">Grant System Access</h2>
                    <p class="text-slate-400 font-medium">Create a new administrative or staff account.</p>
                </div>

                <form wire:submit="createUser" class="space-y-6">
                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Master Name</label>
                        <input wire:model="name" type="text" class="w-full px-5 py-4 bg-slate-50 border-none rounded-2xl text-sm font-bold text-slate-800 placeholder:text-slate-300 focus:ring-4 focus:ring-primary/5 transition-all">
                        @error('name') <span class="text-[10px] font-bold text-red-500 ml-1">{{ $message }}</span> @enderror
                    </div>

                    <div class="grid grid-cols-2 gap-6">
                        <div class="space-y-2">
                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Email Terminal</label>
                            <input wire:model="email" type="email" class="w-full px-5 py-4 bg-slate-50 border-none rounded-2xl text-sm font-bold text-slate-800 placeholder:text-slate-300 focus:ring-4 focus:ring-primary/5 transition-all">
                            @error('email') <span class="text-[10px] font-bold text-red-500 ml-1">{{ $message }}</span> @enderror
                        </div>
                        <div class="space-y-2">
                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Authority Level</label>
                            <select wire:model="role_id" class="w-full px-5 py-4 bg-slate-50 border-none rounded-2xl text-sm font-bold text-slate-800 placeholder:text-slate-300 focus:ring-4 focus:ring-primary/5 transition-all appearance-none cursor-pointer">
                                <option value="">Select Level</option>
                                @foreach(Role::whereNotIn('name', ['user', 'student'])->get() as $role)
                                    <option value="{{ $role->id }}">{{ ucfirst($role->name) }}</option>
                                @endforeach
                            </select>
                            @error('role_id') <span class="text-[10px] font-bold text-red-500 ml-1">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Vault Password</label>
                        <input wire:model="password" type="password" class="w-full px-5 py-4 bg-slate-50 border-none rounded-2xl text-sm font-bold text-slate-800 placeholder:text-slate-300 focus:ring-4 focus:ring-primary/5 transition-all">
                        @error('password') <span class="text-[10px] font-bold text-red-500 ml-1">{{ $message }}</span> @enderror
                    </div>

                    <div class="pt-4 flex gap-4">
                        <button type="button" @click="showModal = false" class="flex-1 py-4 text-slate-400 font-black text-xs uppercase tracking-widest rounded-3xl hover:bg-slate-50 transition-all">Cancel</button>
                        <button type="submit" class="flex-2 py-4 bg-primary text-white font-black text-xs uppercase tracking-widest rounded-3xl shadow-xl shadow-primary/30 active:scale-95 transition-all outline-none">Initialize Key</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>