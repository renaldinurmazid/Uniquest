<?php

namespace App\Livewire\Verification;

use App\Models\ExternalCertificate;
use App\Models\PointTransaction;
use App\Models\StudentProfile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts::app')]
#[Title('Verification Center')]
class Index extends Component
{
    use WithPagination;

    // ── Filter & Search ──────────────────────────
    public string $activeTab      = 'pending';
    public string $search         = '';
    public string $filterStatus   = 'pending';

    // ── Detail / Review modal ────────────────────
    public bool   $showDetailModal = false;
    public bool   $showRejectModal = false;
    public ?int   $selectedId      = null;

    // ── Review form fields ───────────────────────
    public int    $expReward      = 50;
    public int    $coinReward     = 25;
    public string $adminNotes     = '';

    // ── Reject form ──────────────────────────────
    public string $rejectNotes    = '';

    public function updatingSearch(): void
    {
        $this->resetPage();
    }
    public function updatingFilterStatus(): void
    {
        $this->resetPage();
    }

    // ── Switch tab + update filter ────────────────
    public function switchTab(string $tab): void
    {
        $this->activeTab    = $tab;
        $this->filterStatus = $tab === 'all' ? 'all' : $tab;
        $this->resetPage();
    }

    // ────────────────────────────────────────────
    // RENDER
    // ────────────────────────────────────────────
    public function render()
    {
        $certs = ExternalCertificate::with(['user', 'verifier'])
            ->when(
                $this->search,
                fn($q) =>
                $q->where('title', 'like', '%' . $this->search . '%')
                    ->orWhere('organizer', 'like', '%' . $this->search . '%')
                    ->orWhereHas(
                        'user',
                        fn($u) =>
                        $u->where('name', 'like', '%' . $this->search . '%')
                    )
            )
            ->when(
                $this->filterStatus !== 'all',
                fn($q) =>
                $q->where('status', $this->filterStatus)
            )
            ->latest()
            ->paginate(15);

        $stats = [
            'pending'  => ExternalCertificate::where('status', 'pending')->count(),
            'verified' => ExternalCertificate::where('status', 'verified')->count(),
            'rejected' => ExternalCertificate::where('status', 'rejected')->count(),
            'total'    => ExternalCertificate::count(),
        ];

        $selected = $this->selectedId
            ? ExternalCertificate::with(['user', 'verifier'])->find($this->selectedId)
            : null;

        return view('pages.verification.index', compact('certs', 'stats', 'selected'));
    }

    // ────────────────────────────────────────────
    // OPEN DETAIL MODAL
    // ────────────────────────────────────────────
    public function openDetail(int $id): void
    {
        $cert = ExternalCertificate::findOrFail($id);

        $this->selectedId  = $id;
        $this->adminNotes  = $cert->admin_notes ?? '';
        $this->expReward   = $cert->exp_reward_given ?: 50;
        $this->coinReward  = $cert->coin_reward_given ?: 25;

        $this->showDetailModal = true;
    }

    // ────────────────────────────────────────────
    // VERIFY — approve + beri reward
    // ────────────────────────────────────────────
    public function verify(): void
    {
        $this->validate([
            'expReward'  => 'required|integer|min:0|max:9999',
            'coinReward' => 'required|integer|min:0|max:9999',
            'adminNotes' => 'nullable|string|max:1000',
        ]);

        DB::transaction(function () {
            $cert = ExternalCertificate::with('user')->findOrFail($this->selectedId);

            // Update sertifikat
            $cert->update([
                'status'           => 'verified',
                'verified_by'      => Auth::id(),
                'verified_at'      => now(),
                'admin_notes'      => $this->adminNotes ?: null,
                'exp_reward_given' => $this->expReward,
                'coin_reward_given' => $this->coinReward,
            ]);

            // Tambah EXP & coins ke student_profiles
            if ($this->expReward > 0 || $this->coinReward > 0) {
                $profile = StudentProfile::where('user_id', $cert->user_id)->first();

                if ($profile) {
                    $profile->increment('current_exp', $this->expReward);
                    $profile->increment('total_coins', $this->coinReward);
                }
            }

            // Catat point transaction
            if ($this->coinReward > 0) {
                PointTransaction::create([
                    'user_id'      => $cert->user_id,
                    'amount'       => $this->coinReward,
                    'type'         => 'credit',
                    'source'       => 'certificate_reward',
                    'reference_id' => $cert->id,
                    'description'  => 'Certificate verified: ' . $cert->title,
                ]);
            }
        });

        $this->showDetailModal = false;
        $this->reset(['selectedId', 'expReward', 'coinReward', 'adminNotes']);
        session()->flash('status', 'Certificate verified and rewards granted!');
    }

    // ────────────────────────────────────────────
    // OPEN REJECT MODAL
    // ────────────────────────────────────────────
    public function openReject(int $id): void
    {
        $this->selectedId   = $id;
        $this->rejectNotes  = '';
        $this->showDetailModal = false;
        $this->showRejectModal = true;
    }

    // ────────────────────────────────────────────
    // REJECT
    // ────────────────────────────────────────────
    public function reject(): void
    {
        $this->validate([
            'rejectNotes' => 'required|string|min:5|max:1000',
        ]);

        ExternalCertificate::findOrFail($this->selectedId)->update([
            'status'      => 'rejected',
            'verified_by' => Auth::id(),
            'verified_at' => now(),
            'admin_notes' => $this->rejectNotes,
        ]);

        $this->showRejectModal = false;
        $this->reset(['selectedId', 'rejectNotes']);
        session()->flash('status', 'Certificate rejected with notes.');
    }

    // ── Close modals ─────────────────────────────
    public function closeModals(): void
    {
        $this->showDetailModal = false;
        $this->showRejectModal = false;
        $this->reset(['selectedId', 'expReward', 'coinReward', 'adminNotes', 'rejectNotes']);
        $this->expReward  = 50;
        $this->coinReward = 25;
    }
}
