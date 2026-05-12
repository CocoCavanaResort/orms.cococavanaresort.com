<?php

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Models\Booking\Reservation;
use Livewire\Attributes\On;

new #[Layout('layouts::panel', ['title' => 'Reservations'])] class extends Component
{
    public $dateFilter;

    public function mount()
    {
        $this->dateFilter = null; // Default to today's date
    }

    public function with()
    {
        return [
            'reservations' => Reservation::when($this->dateFilter, function ($query) {
                $query->whereDate('check_in_date', '<=', $this->dateFilter)
                      ->whereDate('check_out_date', '>=', $this->dateFilter);
            })->get()
        ];
    }

    #[On('deleteReservation')]
    public function deleteReservation($id)
    {
        $reservation = Reservation::findOrFail($id);
        $reservation->delete();
        $this->dispatch('delete', ['message' => 'Reservation deleted successfully.']);
    }
};
?>

<div class="d-grid h-100 w-100 gap-3" style="grid-template-rows: auto 1fr;">
    <div class="d-flex justify-content-between align-items-center px-2">
        <h5 class="mb-0">Reservations</h5>
        <div class="d-flex align-items-center gap-2">
            <input type="date" id="dateFilter" class="form-control form-control-sm" wire:model.live="dateFilter" />
        </div>
    </div>
    <div class="d-flex flex-column gap-3" style="overflow-y: auto;">
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-3 mw-100">
            @foreach ($reservations as $reservation)
                <div class="col">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            @php
                                $customer = $reservation->customer;
                                $total_days = (new DateTime($reservation->check_out_date))->diff(new DateTime($reservation->check_in_date))->days;
                            @endphp
                            <h5 class="card-title">{{ $customer->first_name }} {{ $customer->last_name }}</h5>
                            <h6 class="card-subtitle mb-2 text-muted">{{ $total_days }} Days</h6>
                            <p class="card-text">Check-in: {{ (new DateTime($reservation->check_in_date))->format('M d, Y') }}<br>Check-out: {{ (new DateTime($reservation->check_out_date))->format('M d, Y') }}</p>
                            <a href="{{ route('reservations.edit', ['id' => $reservation->id]) }}" class="card-link" wire:navigate>View Details</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    <a href="{{ route('reservations.add') }}" class="btn btn-primary">Add New Reservation</a>
</div>