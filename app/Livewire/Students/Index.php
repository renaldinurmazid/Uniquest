<?php

namespace App\Livewire\Students;

use App\Models\User;
use App\Models\StudentProfile;
use App\Models\StudentSkill;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

#[Layout('layouts::app')]
#[Title('Students')]
class Index extends Component
{
    use WithPagination;

    public string $search   = '';
    public string $viewMode = 'grid';

    // Modals
    public bool $showCreate = false;
    public bool $showEdit   = false;
    public bool $showDelete = false;

    // Create
    public string $name     = '';
    public string $email    = '';
    public string $npm      = '';
    public string $password = '';

    // Edit
    public ?int   $editId       = null;
    public string $editName     = '';
    public string $editEmail    = '';
    public string $editNpm      = '';
    public string $editPassword = '';

    // Delete
    public ?int   $deleteId   = null;
    public string $deleteName = '';

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function render()
    {
        $students = User::whereHas('roles', fn($q) => $q->where('name', 'student'))
            ->with(['studentProfile', 'skills'])
            ->where(
                fn($q) =>
                $q->where('name', 'like', "%{$this->search}%")
                    ->orWhere('email', 'like', "%{$this->search}%")
                    ->orWhereHas(
                        'studentProfile',
                        fn($sp) =>
                        $sp->where('npm', 'like', "%{$this->search}%")
                    )
            )
            ->latest()
            ->paginate(12);

        return view('pages.students.index', [
            'students' => $students,
            'stats'    => [
                'total'       => User::whereHas('roles', fn($q) => $q->where('name', 'student'))->count(),
                'avg_level'   => number_format(StudentProfile::avg('level') ?: 1, 1),
                'total_exp'   => number_format(StudentProfile::sum('current_exp')),
                'total_coins' => number_format(StudentProfile::sum('total_coins')),
            ],
        ]);
    }

    // ── CREATE ──────────────────────────────────
    public function createStudent(): void
    {
        $this->validate([
            'name'     => 'required|min:3',
            'email'    => 'required|email|unique:users,email',
            'npm'      => 'required|unique:student_profiles,npm',
            'password' => 'required|min:6',
        ]);

        try {
            DB::transaction(function () {
                $user = User::create([
                    'name'     => $this->name,
                    'email'    => $this->email,
                    'password' => Hash::make($this->password),
                ]);
                $user->assignRole('student');
                StudentProfile::create([
                    'user_id'     => $user->id,
                    'npm'         => $this->npm,
                    'level'       => 1,
                    'current_exp' => 0,
                    'total_coins' => 0,
                ]);
            });
            session()->flash('status', "Hero \"{$this->name}\" enrolled!");
            $this->closeAll();
        } catch (\Exception $e) {
            session()->flash('error', 'Error: ' . $e->getMessage());
        }
    }

    // ── EDIT ────────────────────────────────────
    public function openEdit(int $id): void
    {
        $user = User::with('studentProfile')->findOrFail($id);
        $this->editId       = $user->id;
        $this->editName     = $user->name;
        $this->editEmail    = $user->email;
        $this->editNpm      = $user->studentProfile?->npm ?? '';
        $this->editPassword = '';
        $this->showEdit     = true;
    }

    public function updateStudent(): void
    {
        $this->validate([
            'editName'     => 'required|min:3',
            'editEmail'    => 'required|email|unique:users,email,' . $this->editId,
            'editNpm'      => 'required',
            'editPassword' => 'nullable|min:6',
        ]);

        try {
            DB::transaction(function () {
                $user = User::findOrFail($this->editId);
                $data = ['name' => $this->editName, 'email' => $this->editEmail];
                if (!empty($this->editPassword)) {
                    $data['password'] = Hash::make($this->editPassword);
                }
                $user->update($data);
                $user->studentProfile?->update(['npm' => $this->editNpm]);
            });
            session()->flash('status', "Student \"{$this->editName}\" updated!");
            $this->closeAll();
        } catch (\Exception $e) {
            session()->flash('error', 'Error: ' . $e->getMessage());
        }
    }

    // ── DELETE ──────────────────────────────────
    public function confirmDelete(int $id): void
    {
        $user             = User::findOrFail($id);
        $this->deleteId   = $user->id;
        $this->deleteName = $user->name;
        $this->showDelete = true;
    }

    public function deleteStudent(): void
    {
        try {
            $user = User::findOrFail($this->deleteId);
            $name = $user->name;
            DB::transaction(function () use ($user) {
                StudentSkill::where('user_id', $user->id)->delete();
                $user->studentProfile?->delete();
                $user->roles()->detach();
                $user->delete();
            });
            session()->flash('status', "Hero \"{$name}\" removed.");
            $this->closeAll();
        } catch (\Exception $e) {
            session()->flash('error', 'Error: ' . $e->getMessage());
        }
    }

    // ── CLOSE ALL ───────────────────────────────
    public function closeAll(): void
    {
        $this->showCreate = $this->showEdit = $this->showDelete = false;
        $this->reset([
            'name',
            'email',
            'npm',
            'password',
            'editId',
            'editName',
            'editEmail',
            'editNpm',
            'editPassword',
            'deleteId',
            'deleteName'
        ]);
        $this->resetValidation();
    }
}
