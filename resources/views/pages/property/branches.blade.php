<?php

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Models\Property\Branch;

new #[Layout('layouts::panel', ['title' => 'Branches'])] class extends Component
{
    public function with(): array
    {
        return [
            'branches' => Branch::all(),
        ];
    }

    public function deleteBranch($id)
    {
        $branch = Branch::findOrFail($id);
        $branch->delete();

        session()->flash('success', 'Branch deleted successfully.');
    }
};
?>

<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <a href="{{ route('branches.add') }}" class="btn btn-primary" wire:navigate>Add Branch</a>
    </div>
    <div class="d-flex flex-column gap-3">
        @foreach ($branches as $branch)
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="card-title m-0">{{ $branch->name }}</h5>
                            <p class="card-text small">{{ $branch->location }}</p>
                        </div>
                        <div>
                            <a href="{{ route('branches.edit', ['id' => $branch->id]) }}" class="btn btn-primary" wire:navigate>Edit</a>
                            <button class="btn btn-danger" wire:click="deleteBranch({{ $branch->id }})" wire:confirm="Are you sure you want to delete this branch?">Delete</button>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    <div class="toast-container position-fixed bottom-0 end-0 p-3">
        @if (session('success'))
        <div class="toast align-items-center text-bg-success border-0 show" role="alert" aria-live="assertive" aria-atomic="true" x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)">
            <div class="d-flex">
                <div class="toast-body">
                    {{ session('success') }}
                </div>
            </div>
        </div>
        @endif
    </div>
</div>