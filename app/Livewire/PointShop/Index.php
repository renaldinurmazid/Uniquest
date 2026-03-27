<?php

namespace App\Livewire\PointShop;

use App\Models\Item;
use App\Models\ItemRedemption;
use App\Models\PointTransaction;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts::app')]
#[Title('Point Shop')]
class Index extends Component
{
    use WithPagination;

    // ── Tab & Filter ─────────────────────────────
    public string $activeTab        = 'inventory';
    public string $search           = '';
    public string $filterType       = 'all';
    public string $filterStatus     = 'all';
    public string $redemptionFilter = 'all';

    // ── Modal state ──────────────────────────────
    public bool $showItemModal    = false;
    public bool $showDeleteModal  = false;
    public bool $showRestockModal = false;

    // ── Item form ────────────────────────────────
    public ?int   $editingId    = null;
    public string $itemName     = '';
    public string $itemType     = 'merchandise';
    public string $itemDesc     = '';
    public int    $itemPrice    = 500;
    public int    $itemStock    = 10;
    public bool   $itemIsActive = true;

    // ── Delete ───────────────────────────────────
    public ?int   $deleteId   = null;
    public string $deleteName = '';

    // ── Restock ──────────────────────────────────
    public ?int   $restockId   = null;
    public string $restockName = '';
    public int    $restockQty  = 10;

    // ── Reset page on filter change ──────────────
    public function updatingSearch(): void
    {
        $this->resetPage();
    }
    public function updatingFilterType(): void
    {
        $this->resetPage();
    }
    public function updatingFilterStatus(): void
    {
        $this->resetPage();
    }
    public function updatingRedemptionFilter(): void
    {
        $this->resetPage();
    }

    public function setTab(string $tab): void
    {
        $this->activeTab = $tab;
        $this->resetPage();
    }

    // ────────────────────────────────────────────
    // RENDER — query hanya tab aktif
    // ────────────────────────────────────────────
    public function render()
    {
        // Stats selalu dihitung (ringan, 4 query count/sum)
        $stats = [
            'total'      => Item::count(),
            'pending'    => ItemRedemption::where('status', 'pending')->count(),
            'coinsSpent' => ItemRedemption::whereIn('status', ['verified', 'completed'])->sum('total_price_coins'),
            'outOfStock' => Item::where('stock', 0)->where('is_active', true)->count(),
        ];

        $items       = collect();
        $redemptions = collect();
        $history     = collect();

        // Hanya query tab yang sedang aktif
        if ($this->activeTab === 'inventory') {
            $items = Item::withCount('redemptions')
                ->when(
                    $this->search,
                    fn($q) =>
                    $q->where('name', 'like', "%{$this->search}%")
                        ->orWhere('description', 'like', "%{$this->search}%")
                )
                ->when(
                    $this->filterType !== 'all',
                    fn($q) =>
                    $q->where('type', $this->filterType)
                )
                ->when($this->filterStatus === 'active',   fn($q) => $q->where('is_active', true))
                ->when($this->filterStatus === 'inactive', fn($q) => $q->where('is_active', false))
                ->when($this->filterStatus === 'out',      fn($q) => $q->where('stock', 0))
                ->latest()
                ->paginate(12);
        }

        if ($this->activeTab === 'redemptions') {
            $redemptions = ItemRedemption::with([
                'user:id,name,email,avatar_url',
                'item:id,name,type',
                'verifier:id,name',
            ])
                ->when(
                    $this->redemptionFilter !== 'all',
                    fn($q) =>
                    $q->where('status', $this->redemptionFilter)
                )
                ->latest()
                ->paginate(15);
        }

        if ($this->activeTab === 'history') {
            $history = ItemRedemption::with([
                'user:id,name,email',
                'item:id,name,type',
            ])
                ->whereIn('status', ['verified', 'completed', 'cancelled'])
                ->latest()
                ->paginate(15);
        }

        return view('pages.point-shop.index', compact('stats', 'items', 'redemptions', 'history'));
    }

    // ────────────────────────────────────────────
    // ITEM CRUD
    // ────────────────────────────────────────────
    public function openCreate(): void
    {
        $this->resetItemForm();
        $this->showItemModal = true;
    }

    public function openEdit(int $id): void
    {
        $item = Item::findOrFail($id);
        $this->editingId    = $item->id;
        $this->itemName     = $item->name;
        $this->itemType     = $item->type;
        $this->itemDesc     = $item->description ?? '';
        $this->itemPrice    = $item->price_coins;
        $this->itemStock    = $item->stock;
        $this->itemIsActive = (bool) $item->is_active;
        $this->showItemModal = true;
    }

    public function saveItem(): void
    {
        $this->validate([
            'itemName'  => 'required|string|min:3|max:255',
            'itemType'  => 'required|in:merchandise,voucher,priority_access,other',
            'itemDesc'  => 'nullable|string|max:1000',
            'itemPrice' => 'required|integer|min:1',
            'itemStock' => 'required|integer|min:0',
        ]);

        $data = [
            'name'        => $this->itemName,
            'type'        => $this->itemType,
            'description' => $this->itemDesc ?: null,
            'price_coins' => $this->itemPrice,
            'stock'       => $this->itemStock,
            'is_active'   => $this->itemIsActive,
        ];

        if ($this->editingId) {
            Item::findOrFail($this->editingId)->update($data);
            session()->flash('status', "Item updated: {$this->itemName}");
        } else {
            Item::create($data);
            session()->flash('status', "Item added: {$this->itemName}");
        }

        $this->showItemModal = false;
        $this->resetItemForm();
    }

    public function confirmDelete(int $id): void
    {
        $item = Item::findOrFail($id);
        $this->deleteId      = $item->id;
        $this->deleteName    = $item->name;
        $this->showDeleteModal = true;
    }

    public function deleteItem(): void
    {
        $item = Item::findOrFail($this->deleteId);
        $name = $item->name;
        $item->redemptions()->delete();
        $item->delete();
        $this->reset(['deleteId', 'deleteName']);
        $this->showDeleteModal = false;
        session()->flash('status', "Item removed: {$name}");
    }

    public function openRestock(int $id): void
    {
        $item = Item::findOrFail($id);
        $this->restockId      = $item->id;
        $this->restockName    = $item->name;
        $this->restockQty     = 10;
        $this->showRestockModal = true;
    }

    public function restock(): void
    {
        $this->validate(['restockQty' => 'required|integer|min:1|max:9999']);

        $item  = Item::findOrFail($this->restockId);
        $added = $this->restockQty;
        $item->increment('stock', $added);

        $this->reset(['restockId', 'restockName', 'restockQty']);
        $this->showRestockModal = false;
        session()->flash('status', "Stock updated for {$item->name} (+{$added})");
    }

    // ────────────────────────────────────────────
    // REDEMPTION MANAGEMENT
    // ────────────────────────────────────────────
    public function verifyRedemption(int $id): void
    {
        DB::transaction(function () use ($id) {
            $r = ItemRedemption::with('item')->findOrFail($id);
            if ($r->status !== 'pending') return;
            $r->update([
                'status'      => 'verified',
                'verified_at' => now(),
                'verified_by' => Auth::id(),
            ]);
            $r->item->decrement('stock', $r->quantity);
        });

        session()->flash('status', 'Redemption #' . str_pad($id, 6, '0', STR_PAD_LEFT) . ' verified!');
    }

    public function rejectRedemption(int $id): void
    {
        DB::transaction(function () use ($id) {
            $r = ItemRedemption::with(['user', 'item'])->findOrFail($id);
            if ($r->status !== 'pending') return;
            $r->update(['status' => 'cancelled']);
            PointTransaction::create([
                'user_id'      => $r->user_id,
                'amount'       => $r->total_price_coins,
                'type'         => 'credit',
                'source'       => 'redemption_refund',
                'reference_id' => $r->id,
                'description'  => 'Refund: rejected redemption for ' . $r->item?->name,
            ]);
        });

        session()->flash('status', 'Redemption rejected and coins refunded.');
    }

    private function resetItemForm(): void
    {
        $this->editingId    = null;
        $this->itemName     = '';
        $this->itemType     = 'merchandise';
        $this->itemDesc     = '';
        $this->itemPrice    = 500;
        $this->itemStock    = 10;
        $this->itemIsActive = true;
        $this->resetValidation();
    }
}
