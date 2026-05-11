<?php

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Models\Booking\Customer;

new #[Layout('layouts::panel', ['title' => 'Customers'])] class extends Component
{
    public $search = '';
    
    public function with()
    {
        return [
            'customers' => Customer::when($this->search, function($query) {
                $query->where('first_name', 'like', '%' . $this->search . '%')
                      ->orWhere('last_name', 'like', '%' . $this->search . '%')
                      ->orWhere('email', 'like', '%' . $this->search . '%');
            })->latest()->get(),
        ];
    }
};
?>

<div class="d-grid h-100 w-100" style="grid-template-rows: auto 1fr auto;">
    <input type="search" class="form-control form-control-sm" placeholder="Search customers..." wire:model.live="search">
    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-3">
        @foreach ($customers as $customer)
            <div class="col">
                @livewire('settings.card', [
                    'title' => $customer->name,
                    'subtitle' => $customer->email,
                    'editUrl' => route('customers.edit', $customer),
                    'deleteEvent' => "deleteCustomer({$customer->id})",
                ])
            </div>
        @endforeach
    </div>
    <a href="{{ route('customers.add') }}" class="btn btn-sm btn-primary" wire:navigate>Add Customer</a>
</div>