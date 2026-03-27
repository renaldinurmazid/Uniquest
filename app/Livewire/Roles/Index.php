<?php

namespace App\Livewire\Roles;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Illuminate\Support\Str;

#[Layout('layouts::app')]
#[Title('Roles & Access')]
class Index extends Component
{
    use WithPagination;

    public string $search = '';
    public string $activeTab = 'roles';

    // Modals
    public bool $showCreate = false;
    public bool $showEdit   = false;
    public bool $showDelete = false;
    public bool $showPerms  = false;

    // Fields
    public string $name = '';
    public ?int   $editId = null;
    public string $editName = '';
    public ?int   $deleteId = null;
    public string $deleteName = '';
    public ?int   $permRoleId = null;
    public string $permRoleName = '';
    public array  $selectedPerms = [];

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function render()
    {
        $allRoles = Role::with('permissions')->orderBy('id')->get();

        return view('pages.roles.index', [
            'roles' => Role::withCount(['users', 'permissions'])
                ->when($this->search, fn($q) => $q->where('name', 'like', "%{$this->search}%"))
                ->orderBy('id')->paginate(15),

            'allPermissions' => Permission::orderBy('name')->get(),
            'allRoles' => $allRoles,

            'stats' => [
                'total_roles'       => Role::count(),
                'total_permissions' => Permission::count(),
                'admin_count'       => Role::whereIn('name', ['admin', 'superadmin', 'staff'])
                    ->withCount('users')->get()->sum('users_count'),
                'sub_admin_count'   => Role::where('name', 'sub-admin')
                    ->withCount('users')->first()?->users_count ?? 0,
            ],

            'matrixData' => Permission::orderBy('name')->get()
                ->map(fn($perm) => [
                    'label' => $perm->name,
                    'cells' => $allRoles->map(fn($role) => $role->hasPermissionTo($perm->name))->toArray(),
                ])->toArray(),
        ]);
    }

    public function createRole(): void
    {
        $this->validate(['name' => 'required|min:2|unique:roles,name']);

        Role::create([
            'name'       => Str::slug($this->name, '-'),
            'guard_name' => 'web',
        ]);

        session()->flash('status', "Role created!");
        $this->closeAll();
    }

    public function openEdit(int $id): void
    {
        $role            = Role::findOrFail($id);
        $this->editId    = $role->id;
        $this->editName  = $role->name;
        $this->showEdit  = true;
    }

    public function updateRole(): void
    {
        $this->validate(['editName' => 'required|min:2|unique:roles,name,' . $this->editId]);

        $role = Role::findOrFail($this->editId);
        $role->update(['name' => Str::slug($this->editName, '-')]);

        session()->flash('status', "Role updated!");
        $this->closeAll();
    }

    public function confirmDelete(int $id): void
    {
        $role             = Role::findOrFail($id);
        $this->deleteId   = $role->id;
        $this->deleteName = $role->name;
        $this->showDelete = true;
    }

    public function deleteRole(): void
    {
        $role = Role::findOrFail($this->deleteId);
        $role->syncPermissions([]);
        $role->delete();

        session()->flash('status', "Role deleted.");
        $this->closeAll();
    }

    public function openPerms(int $id): void
    {
        $role                = Role::with('permissions')->findOrFail($id);
        $this->permRoleId    = $role->id;
        $this->permRoleName  = $role->name;
        // Ambil ID permission yang dimiliki role
        $this->selectedPerms = $role->permissions->pluck('id')->toArray();
        $this->showPerms     = true;
    }

    public function togglePerm(int $permId): void
    {
        if (in_array($permId, $this->selectedPerms)) {
            $this->selectedPerms = array_diff($this->selectedPerms, [$permId]);
        } else {
            $this->selectedPerms[] = $permId;
        }
    }

    public function savePerms(): void
    {
        $role = Role::findOrFail($this->permRoleId);
        // Sinkronisasi ID permission ke role (Spatie syncPermissions bisa nerima array ID)
        $role->syncPermissions($this->selectedPerms);

        session()->flash('status', "Permissions updated!");
        $this->closeAll();
    }

    public function closeAll(): void
    {
        $this->showCreate = $this->showEdit = $this->showDelete = $this->showPerms = false;
        $this->reset(['name', 'editId', 'editName', 'deleteId', 'deleteName', 'permRoleId', 'permRoleName', 'selectedPerms']);
        $this->resetValidation();
    }
}
