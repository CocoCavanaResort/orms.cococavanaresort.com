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
    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-3">
        @foreach ($branches as $branch)
            <div class="col">
                <div class="card h-100 shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title m-0">{{ $branch->name }}</h5>
                        <p class="card-text small">{{ $branch->location }}</p>
                    </div>
                    <div class="card-footer d-flex justify-content-end gap-2">
                        <a href="{{ route('branches.edit', ['id' => $branch->id]) }}" class="btn btn-sm btn-primary" wire:navigate>Edit</a>
                        <button class="btn btn-sm btn-danger" wire:click="deleteBranch({{ $branch->id }})" wire:confirm="Are you sure you want to delete this branch?">Delete</button>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>