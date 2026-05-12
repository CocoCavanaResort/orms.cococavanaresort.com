<?php

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Models\Booking\Customer;

new #[Layout('layouts::panel', ['title' => 'Add Customer'])] class extends Component
{
    public $first_name;
    public $last_name;
    public $email;
    public $phone_number;
    public $address;

    public function saveCustomer()
    {
        $this->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:customers,email',
            'phone_number' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
        ]);

        Customer::create([
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'email' => $this->email,
            'phone_number' => $this->phone_number,
            'address' => $this->address,
        ]);

        $this->dispatch('alert', ['type' => 'success', 'message' => 'Customer added successfully.']);
        $this->redirect(route('customers'), true);
    }
};
?>

<div class="container-fluid">
    <div class="card">
        <div class="card-body">
            <h2 class="card-title">Add Customer</h2>
            <form wire:submit.prevent="saveCustomer">
                <div class="mb-3">
                    <label for="first_name" class="form-label">First Name</label>
                    <input type="text" class="form-control @error('first_name') is-invalid @enderror" id="first_name" wire:model.defer="first_name">
                    @error('first_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="mb-3">
                    <label for="last_name" class="form-label">Last Name</label>
                    <input type="text" class="form-control @error('last_name') is-invalid @enderror" id="last_name" wire:model.defer="last_name">
                    @error('last_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" wire:model.defer="email">
                    @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="mb-3">
                    <label for="phone_number" class="form-label">Phone</label>
                    <input type="text" class="form-control @error('phone_number') is-invalid @enderror" id="phone_number" wire:model.defer="phone_number">
                    @error('phone_number') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="mb-3">
                    <label for="address" class="form-label">Address</label>
                    <textarea class="form-control @error('address') is-invalid @enderror" id="address" rows="3" wire:model.defer="address"></textarea>
                    @error('address') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <button type="submit" class="btn btn-primary">Save Customer</button>
            </form>
        </div>
    </div>
</div>