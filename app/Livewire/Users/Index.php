<?php

namespace App\Livewire\Users;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Permission\Models\Role;

#[Layout('layouts::app')]
#[Title('System Users')]
class Index extends Component
{
    use WithPagination;

    // ── Search ──────────────────────────────────
    public string $search = '';

    // ── Modal state ─────────────────────────────
    public bool $showCreate = false;
    public bool $showEdit   = false;
    public bool $showDelete = false;

    // ── Create fields ───────────────────────────
    public string $name     = '';
    public string $email    = '';
    public array  $roleIds  = [];   // multi-role
    public string $password = '';

    // ── Edit fields ─────────────────────────────
    public ?int   $editId       = null;
    public string $editName     = '';
    public string $editEmail    = '';
    public array  $editRoleIds  = [];   // multi-role
    public string $editPassword = '';

    // ── Delete fields ───────────────────────────
    public ?int   $deleteId   = null;
    public string $deleteName = '';

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    // ────────────────────────────────────────────
    // RENDER
    // ────────────────────────────────────────────
    public function render()
    {
        $users = User::with('roles')
            ->where(function ($q) {
                $q->where('name', 'like', '%' . $this->search . '%')
                    ->orWhere('email', 'like', '%' . $this->search . '%');
            })
            ->latest()
            ->paginate(15);

        $roles = Role::orderBy('name')->get();

        return view('pages.users.index', compact('users', 'roles'));
    }

    // ────────────────────────────────────────────
    // CREATE
    // ────────────────────────────────────────────
    public function createUser(): void
    {
        $this->validate([
            'name'     => 'required|min:3|max:255',
            'email'    => 'required|email|unique:users,email',
            'roleIds'  => 'required|array|min:1',
            'roleIds.*' => 'exists:roles,id',
            'password' => 'required|min:6',
        ], [
            'roleIds.required' => 'Please select at least one role.',
            'roleIds.min'      => 'Please select at least one role.',
        ]);

        $user = User::create([
            'name'     => $this->name,
            'email'    => $this->email,
            'password' => Hash::make($this->password),
        ]);

        // Sync multiple roles by name
        $roleNames = Role::whereIn('id', $this->roleIds)->pluck('name')->toArray();
        $user->syncRoles($roleNames);

        $this->reset(['name', 'email', 'roleIds', 'password']);
        $this->showCreate = false;
        session()->flash('status', 'Access granted to ' . $user->name);
    }

    // ────────────────────────────────────────────
    // EDIT
    // ────────────────────────────────────────────
    public function openEdit(int $userId): void
    {
        $user = User::with('roles')->findOrFail($userId);

        $this->editId       = $user->id;
        $this->editName     = $user->name;
        $this->editEmail    = $user->email;
        $this->editRoleIds  = $user->roles->pluck('id')->map(fn($id) => (string) $id)->toArray();
        $this->editPassword = '';

        $this->showEdit = true;
    }

    public function updateUser(): void
    {
        $this->validate([
            'editName'      => 'required|min:3|max:255',
            'editEmail'     => 'required|email|unique:users,email,' . $this->editId,
            'editRoleIds'   => 'required|array|min:1',
            'editRoleIds.*' => 'exists:roles,id',
            'editPassword'  => 'nullable|min:6',
        ], [
            'editRoleIds.required' => 'Please select at least one role.',
            'editRoleIds.min'      => 'Please select at least one role.',
        ]);

        $user = User::findOrFail($this->editId);

        $data = [
            'name'  => $this->editName,
            'email' => $this->editEmail,
        ];

        if (! empty($this->editPassword)) {
            $data['password'] = Hash::make($this->editPassword);
        }

        $user->update($data);

        // Sync multiple roles by name
        $roleNames = Role::whereIn('id', $this->editRoleIds)->pluck('name')->toArray();
        $user->syncRoles($roleNames);

        $this->reset(['editId', 'editName', 'editEmail', 'editRoleIds', 'editPassword']);
        $this->showEdit = false;
        session()->flash('status', 'Account updated: ' . $user->name);
    }

    // ────────────────────────────────────────────
    // DELETE
    // ────────────────────────────────────────────
    public function confirmDelete(int $userId): void
    {
        $user = User::findOrFail($userId);

        $this->deleteId   = $user->id;
        $this->deleteName = $user->name;
        $this->showDelete = true;
    }

    public function deleteUser(): void
    {
        $user = User::findOrFail($this->deleteId);
        $name = $user->name;

        $user->syncRoles([]);
        $user->delete();

        $this->reset(['deleteId', 'deleteName']);
        $this->showDelete = false;
        session()->flash('status', 'Account removed: ' . $name);
    }
}
