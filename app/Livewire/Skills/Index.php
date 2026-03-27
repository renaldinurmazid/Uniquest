<?php

namespace App\Livewire\Skills;

use App\Models\Skill;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts::app')]
#[Title('Skills Master')]
class Index extends Component
{
    use WithPagination;

    // ── Search ──────────────────────────────────
    public string $search = '';

    // ── Modal state ─────────────────────────────
    public bool $showModal      = false;
    public bool $showDeleteModal = false;

    // ── Form fields ─────────────────────────────
    public ?int   $editingId   = null;
    public string $name        = '';
    public string $description = '';
    public string $colorHex    = '#7c3aed';

    // Preset warna — user pilih dari palette
    public array $colorPalette = [
        '#7c3aed', // violet
        '#8b5cf6', // violet light
        '#3b82f6', // blue
        '#06b6d4', // cyan
        '#10b981', // emerald
        '#f59e0b', // amber
        '#ef4444', // red
        '#ec4899', // pink
        '#f97316', // orange
        '#84cc16', // lime
    ];

    // ── Delete ──────────────────────────────────
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
        $skills = Skill::withCount(['users', 'events'])
            ->when(
                $this->search,
                fn($q) =>
                $q->where('name', 'like', '%' . $this->search . '%')
                    ->orWhere('description', 'like', '%' . $this->search . '%')
            )
            ->latest()
            ->paginate(12);

        $stats = [
            'total'        => Skill::count(),
            'totalAssigned' => \DB::table('student_skills')->distinct('skill_id')->count('skill_id'),
            'totalPoints'  => \DB::table('student_skills')->sum('points'),
            'totalEvents'  => \DB::table('event_skills')->distinct('skill_id')->count('skill_id'),
        ];

        return view('pages.skills.index', compact('skills', 'stats'));
    }

    // ────────────────────────────────────────────
    // CREATE
    // ────────────────────────────────────────────
    public function openCreate(): void
    {
        $this->resetForm();
        $this->editingId = null;
        $this->showModal = true;
    }

    // ────────────────────────────────────────────
    // EDIT
    // ────────────────────────────────────────────
    public function openEdit(int $skillId): void
    {
        $skill = Skill::findOrFail($skillId);

        $this->editingId   = $skill->id;
        $this->name        = $skill->name;
        $this->description = $skill->description ?? '';
        $this->colorHex    = $skill->color_hex ?? '#7c3aed';

        $this->showModal = true;
    }

    // ────────────────────────────────────────────
    // SAVE (create atau update)
    // ────────────────────────────────────────────
    public function save(): void
    {
        $this->validate([
            'name'        => 'required|string|min:2|max:100',
            'description' => 'nullable|string|max:500',
            'colorHex'    => 'required|string|regex:/^#[0-9A-Fa-f]{6}$/',
        ]);

        $data = [
            'name'        => $this->name,
            'description' => $this->description ?: null,
            'color_hex'   => $this->colorHex,
        ];

        if ($this->editingId) {
            Skill::findOrFail($this->editingId)->update($data);
            session()->flash('status', 'Skill updated: ' . $this->name);
        } else {
            Skill::create($data);
            session()->flash('status', 'Skill created: ' . $this->name);
        }

        $this->showModal = false;
        $this->resetForm();
    }

    // ────────────────────────────────────────────
    // DELETE
    // ────────────────────────────────────────────
    public function confirmDelete(int $skillId): void
    {
        $skill = Skill::findOrFail($skillId);

        $this->deleteId        = $skill->id;
        $this->deleteName      = $skill->name;
        $this->showDeleteModal = true;
    }

    public function delete(): void
    {
        $skill = Skill::findOrFail($this->deleteId);
        $name  = $skill->name;

        // Detach relasi pivot dulu
        $skill->users()->detach();
        $skill->events()->detach();
        $skill->delete();

        $this->reset(['deleteId', 'deleteName']);
        $this->showDeleteModal = false;
        session()->flash('status', 'Skill removed: ' . $name);
    }

    // ────────────────────────────────────────────
    // HELPER
    // ────────────────────────────────────────────
    private function resetForm(): void
    {
        $this->editingId   = null;
        $this->name        = '';
        $this->description = '';
        $this->colorHex    = '#7c3aed';
    }
}
