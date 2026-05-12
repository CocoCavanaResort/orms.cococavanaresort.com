<?php

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Models\Booking\Discount;
use Livewire\Attributes\On;

new #[Layout('layouts::panel', ['title' => 'Discounts'])] class extends Component
{
    public $search = '';

    public function with(): array
    {
        return [
            'discounts' => Discount::query()
                ->where('description', 'like', '%' . $this->search . '%')
                ->orWhere('code', 'like', '%' . $this->search . '%')
                ->latest()
                ->get(),
        ];
    }

    #[On("deleteDiscount")]
    public function deleteDiscount($id)
    {
        $discount = Discount::findOrFail($id);
        $discount->delete();
        $this->dispatch('alert', ['type' => 'success', 'message' => 'Discount deleted successfully.']);
    }
};
?>

<div class="d-grid h-100 w-100 gap-3" style="grid-template-rows: auto 1fr;">
    <div class="d-flex justify-content-between align-items-center px-2">
        <h5 class="mb-0">Discounts</h5>
        <div>
            <input type="search" class="form-control form-control-sm" placeholder="Search discounts..." wire:model.live="search" />
        </div>
    </div>
    <div class="d-flex flex-column gap-3" style="overflow-y: auto;">
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-3">
            @foreach ($discounts as $discount)
                <div class="col">
                    @livewire('settings.card', [
                        'id' => $discount->id,
                        'title' => $discount->description,
                        'subtitle' => $discount->code,
                        'details' => number_format($discount->amount, $discount->is_percentage ? 0 : 2) . ($discount->is_percentage ? '%' : ' PHP'),
                        'editUrl' => route('discounts.edit', ['id' => $discount->id]),
                        'deleteAction' => "deleteDiscount",
                    ], key($discount->id))
                </div>
            @endforeach
        </div>
    </div>
    <a href="{{ route('discounts.add') }}" class="btn btn-sm btn-primary" wire:navigate>Add Discount</a>
</div>