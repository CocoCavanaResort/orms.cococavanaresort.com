<?php

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Models\Booking\Customer;
use Livewire\Attributes\On;

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

    #[On("deleteCustomer")]
    public function deleteCustomer($id)
    {
        $customer = Customer::findOrFail($id);
        $customer->delete();
        $this->dispatch('alert', ['type' => 'success', 'message' => 'Customer deleted successfully.']);
    }
};
?>

<div class="d-grid h-100 w-100 gap-3" style="grid-template-rows: auto 1fr auto;">
    <div class="d-flex justify-content-between align-items-center px-2">
        <h5 class="mb-0">Customers</h5>
        <div>
            <input type="search" class="form-control form-control-sm" placeholder="Search customers..." wire:model.live="search">
        </div>
    </div>
    <div class="d-flex flex-column gap-3" style="overflow-y: auto;">
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-3">
            @foreach ($customers as $customer)
                <div class="col">
                    @livewire('settings.card', [
                        'id' => $customer->id,
                        'title' => "{$customer->first_name} {$customer->last_name}",
                        'subtitle' => $customer->email,
                        'details' => "Phone: {$customer->phone_number} Address: {$customer->address}",
                        'editUrl' => route('customers.edit', $customer),
                        'deleteAction' => "deleteCustomer",
                    ])
                </div>
            @endforeach
        </div>
    </div>
    <a href="{{ route('customers.add') }}" class="btn btn-sm btn-primary" wire:navigate>Add Customer</a>
</div>