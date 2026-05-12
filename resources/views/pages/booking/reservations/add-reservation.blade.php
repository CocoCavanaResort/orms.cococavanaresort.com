<?php

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Models\Booking\Reservation;
use App\Models\Booking\Customer;

new #[Layout('layouts::panel', ['title' => 'Add Reservation'])] class extends Component
{
    public $customer_id;
    public $stay_type = 'overnight';
    public $check_in_date;
    public $check_out_date;
    public $number_of_adults;
    public $number_of_kids;

    public function with()
    {
        return [
            'customers' => Customer::all()
        ];
    }

    public function save()
    {
        $this->validate([
            'customer_id' => 'required|exists:customers,id',
            'check_in_date' => 'required|date',
            'check_out_date' => 'required|date|after:check_in_date',
            'number_of_adults' => 'required|integer|min:1',
            'number_of_kids' => 'required|integer|min:0',
            'stay_type' => 'required|string',
        ]);

        Reservation::create([
            'customer_id' => $this->customer_id,
            'stay_type' => $this->stay_type,
            'check_in_date' => $this->check_in_date,
            'check_out_date' => $this->check_out_date,
            'number_of_adults' => $this->number_of_adults,
            'number_of_kids' => $this->number_of_kids,
            'status' => 'booked',
        ]);

        $this->dispatch('success', ['message' => 'Reservation created successfully.']);
        $this->redirect(route('reservations'));
    }
};
?>

<div class="container-fluid">
    <div class="card">
        <div class="card-body">
            <h2 class="card-title">Add Reservation</h2>
            <form wire:submit.prevent="save">
                <div class="mb-3">
                    <label for="customer_id" class="form-label">Customer</label>
                    <select class="form-select @error('customer_id') is-invalid @enderror" id="customer_id" wire:model.defer="customer_id">
                        <option value="">Select a customer</option>
                        @foreach ($customers as $customer)
                            <option value="{{ $customer->id }}">{{ $customer->first_name }} {{ $customer->last_name }}</option>
                        @endforeach
                    </select>
                    @error('customer_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="mb-3">
                    <label for="stay_type" class="form-label">Stay Type</label>
                    <select class="form-select @error('stay_type') is-invalid @enderror" id="stay_type" wire:model.defer="stay_type">
                        <option value="overnight" selected>Overnight</option>
                        <option value="day-tour">Day Tour</option>
                    </select>
                    @error('stay_type') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="mb-3">
                    <label for="check_in_date" class="form-label">Check-in Date</label>
                    <input type="date" class="form-control @error('check_in_date') is-invalid @enderror" id="check_in_date" wire:model.defer="check_in_date">
                    @error('check_in_date') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="mb-3">
                    <label for="check_out_date" class="form-label">Check-out Date</label>
                    <input type="date" class="form-control @error('check_out_date') is-invalid @enderror" id="check_out_date" wire:model.defer="check_out_date" @if>
                    @error('check_out_date') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="mb-3">
                    <label for="number_of_adults" class="form-label">Number of Adults</label>
                    <input type="number" class="form-control @error('number_of_adults') is-invalid @enderror" id="number_of_adults" wire:model.defer="number_of_adults" min="1">
                    @error('number_of_adults') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="mb-3">
                    <label for="number_of_kids" class="form-label">Number of Kids</label>
                    <input type="number" class="form-control @error('number_of_kids') is-invalid @enderror" id="number_of_kids" wire:model.defer="number_of_kids" min="0">
                    @error('number_of_kids') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <button type="submit" class="btn btn-primary">Save Reservation</button>
            </form>
        </div>
    </div>
</div>