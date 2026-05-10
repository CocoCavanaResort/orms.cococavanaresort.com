<?php

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Models\Property\Room;

new #[Layout('layouts::panel', ['title' => 'Add Room'])] class extends Component
{
    public $name;
    public $branch_id;
    public $capacity;
    public $price;
    public $status;

    public function with(): array
    {
        return [
            'branches' => \App\Models\Property\Branch::all(),
        ];
    }

    public function addRoom()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'branch_id' => 'required|exists:branches,id',
            'capacity' => 'required|integer|min:1',
            'price' => 'required|numeric|min:0',
            'status' => 'required|string|in:active,inactive',
        ]);

        Room::create([
            'name' => $this->name,
            'branch_id' => $this->branch_id,
            'capacity' => $this->capacity,
            'price' => $this->price,
            'status' => $this->status,
        ]);

        session()->flash('success', 'Room added successfully.');
        $this->redirect(route('rooms'), true);
    }
};
?>

<div class="container-fluid">
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Add Room</h5>
            <form wire:submit.prevent="addRoom">
                <div class="mb-3">
                    <label for="name" class="form-label">Room Name</label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" wire:model.defer="name">
                    @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                @if (Auth::id() == 1)
                <div class="mb-3">
                    <label for="branch_id" class="form-label">Branch</label>
                    <select class="form-select @error('branch_id') is-invalid @enderror" id="branch_id" wire:model.defer="branch_id">
                        <option value="">Select Branch</option>
                        @foreach ($branches as $branch)
                            <option value="{{ $branch->id }}">{{ $branch->name }}</option>
                        @endforeach
                    </select>
                    @error('branch_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                @else
                <input type="hidden" wire:model.defer="branch_id" value="{{ Auth::user()->branch_id }}">
                @endif
                <div class="mb-3">
                    <label for="capacity" class="form-label">Capacity</label>
                    <input type="number" class="form-control @error('capacity') is-invalid @enderror" id="capacity" wire:model.defer="capacity">
                    @error('capacity') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="mb-3">
                    <label for="price" class="form-label">Price</label>
                    <input type="number" class="form-control @error('price') is-invalid @enderror" id="price" wire:model.defer="price" step="0.01">
                    @error('price') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="mb-3">
                    <label for="status" class="form-label">Status</label>
                    <select class="form-select @error('status') is-invalid @enderror" id="status" wire:model.defer="status">
                        <option value="">Select Status</option>
                        <option value="active">Active</option>
                        <option value="inactive">Inactive</option>
                    </select>
                    @error('status') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <button type="submit" class="btn btn-primary">Add Room</button>
            </form>
        </div>
    </div>
</div>