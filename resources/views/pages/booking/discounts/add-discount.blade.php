<?php

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Models\Booking\Discount;

new #[Layout('layouts::panel', ['title' => 'Add Discount'])] class extends Component
{
    public $code;
    public $description;
    public $amount;
    public $is_percentage = false;

    public function save()
    {
        $this->validate([
            'code' => 'required|unique:discounts,code',
            'description' => 'required',
            'amount' => 'required|numeric|min:0',
        ]);

        Discount::create([
            'code' => $this->code,
            'description' => $this->description,
            'amount' => $this->amount,
            'is_percentage' => $this->is_percentage,
        ]);

        $this->dispatch('alert', ['type' => 'success', 'message' => 'Discount created successfully.']);
        $this->redirect(route('discounts'), true);
    }
};
?>

<div class="container-fluid">
    <div class="card">
        <div class="card-body">
            <h2 class="card-title">Add Discount</h2>
            <form wire:submit.prevent="save">
                <div class="mb-3">
                    <label for="code" class="form-label">Discount Code</label>
                    <input type="text" class="form-control @error('code') is-invalid @enderror" id="code" wire:model.defer="code">
                    @error('code') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <input type="text" class="form-control @error('description') is-invalid @enderror" id="description" wire:model.defer="description">
                    @error('description') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="mb-3">
                    <label for="amount" class="form-label">Amount</label>
                    <input type="number" step="0.01" class="form-control @error('amount') is-invalid @enderror" id="amount" wire:model.defer="amount">
                    @error('amount') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="mb-3 form-check">
                    <input type="checkbox" class="form-check-input" id="is_percentage" wire:model.defer="is_percentage">
                    <label class="form-check-label" for="is_percentage">Is Percentage?</label>
                </div>
                <button type="submit" class="btn btn-primary">Save Discount</button>
            </form>
        </div>
    </div>
</div>