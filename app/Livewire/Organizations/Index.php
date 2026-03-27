<?php

namespace App\Livewire\Organizations;

use App\Models\Organization;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;

#[Layout('layouts::app')]
#[Title('Organizations')]
class Index extends Component
{
    use WithPagination;

    private function authorizeManage(): void
    {
        abort_if(auth()->user()->hasRole('sub-admin'), 403, 'Sub-admin cannot manage organizations.');
    }

    public string $search    = '';
    public string $activeTab = 'all';

    // Modals
    public bool $showCreate = false;
    public bool $showEdit   = false;
    public bool $showDelete = false;

    // Create fields
    public string $name        = '';
    public string $description = '';
    public int    $userId      = 0;

    // Edit fields
    public ?int   $editId          = null;
    public string $editName        = '';
    public string $editDescription = '';
    public int    $editUserId      = 0;

    // Delete fields
    public ?int   $deleteId   = null;
    public string $deleteName = '';

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function render()
    {
        $query = Organization::with('owner')
            ->withCount('events')
            ->when(
                $this->search,
                fn($q) =>
                $q->where('name', 'like', "%{$this->search}%")
                    ->orWhere('description', 'like', "%{$this->search}%")
            );

        if ($this->activeTab !== 'all') {
            $query->where('name', 'like', "%{$this->activeTab}%");
        }

        return view('pages.organizations.index', [
            'organizations' => $query->latest()->paginate(12),
            'leaders'       => User::orderBy('name')->get(['id', 'name', 'email']),
            'isSubAdmin'    => auth()->user()->hasRole('sub-admin'),
            'stats'         => [
                'total'   => Organization::count(),
                'active'  => Organization::whereNotNull('name')->count(),
                'members' => 0,
                'pending' => 0,
            ],
        ]);
    }

    // ── CREATE ──────────────────────────────────
    public function createOrganization(): void
    {
        $this->authorizeManage(); // ← di awal, bukan di akhir

        $this->validate([
            'name'        => 'required|min:3|unique:organizations,name',
            'description' => 'required|min:10',
            'userId'      => 'required|exists:users,id',
        ]);

        Organization::create([
            'name'        => $this->name,
            'description' => $this->description,
            'user_id'     => $this->userId,
        ]);

        session()->flash('status', "Organization \"{$this->name}\" registered!");
        $this->closeAll();
    }

    // ── EDIT ────────────────────────────────────
    public function openEdit(int $id): void
    {
        $this->authorizeManage(); // ← di awal

        $org                   = Organization::findOrFail($id);
        $this->editId          = $org->id;
        $this->editName        = $org->name;
        $this->editDescription = $org->description ?? '';
        $this->editUserId      = $org->user_id ?? 0;
        $this->showEdit        = true;
    }

    public function updateOrganization(): void
    {
        $this->authorizeManage(); // ← di awal

        $this->validate([
            'editName'        => 'required|min:3|unique:organizations,name,' . $this->editId,
            'editDescription' => 'required|min:10',
            'editUserId'      => 'required|exists:users,id',
        ]);

        $org = Organization::findOrFail($this->editId);
        $org->update([
            'name'        => $this->editName,
            'description' => $this->editDescription,
            'user_id'     => $this->editUserId,
        ]);

        session()->flash('status', "Organization \"{$org->name}\" updated!");
        $this->closeAll();
    }

    // ── DELETE ──────────────────────────────────
    public function confirmDelete(int $id): void
    {
        $this->authorizeManage(); // ← di awal

        $org              = Organization::findOrFail($id);
        $this->deleteId   = $org->id;
        $this->deleteName = $org->name;
        $this->showDelete = true;
    }

    public function deleteOrganization(): void
    {
        $this->authorizeManage(); // ← di awal

        $org  = Organization::findOrFail($this->deleteId);
        $name = $org->name;
        $org->delete();

        session()->flash('status', "Organization \"{$name}\" deleted.");
        $this->closeAll();
    }

    // ── CLOSE ALL ───────────────────────────────
    public function closeAll(): void
    {
        $this->showCreate = $this->showEdit = $this->showDelete = false;
        $this->reset([
            'name',
            'description',
            'userId',
            'editId',
            'editName',
            'editDescription',
            'editUserId',
            'deleteId',
            'deleteName',
        ]);
        $this->resetValidation();
    }
}
