<?php

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Models\Property\Branch;

new #[Layout('layouts::panel', ['title' => 'Branches'])] class extends Component
{
    public $name;
    public $location;
    public function addBranch()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
        ]);

        Branch::create([
            'name' => $this->name,
            'location' => $this->location,
        ]);

        session()->flash('success', 'Branch added successfully.');
        $this->redirect(route('branches'), true);
    }
};
?>

<div class="container-fluid">
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Add Branch</h5>
            <form wire:submit.prevent="addBranch">
                <div class="mb-3">
                    <label for="name" class="form-label">Branch Name</label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" wire:model.defer="name">
                    @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="mb-3">
                    <label for="location" class="form-label">Location</label>
                    <input type="text" class="form-control @error('location') is-invalid @enderror" id="location" wire:model.defer="location">
                    @error('location') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <button type="submit" class="btn btn-primary">Add Branch</button>
            </form>
        </div>
    </div>
</div>