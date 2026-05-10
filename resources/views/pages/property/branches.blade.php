<?php

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Models\Property\Branch;
use Livewire\Attributes\On;

new #[Layout('layouts::panel', ['title' => 'Branches'])] class extends Component
{
    public function with(): array
    {
        return [
            'branches' => Branch::all(),
        ];
    }

    #[On("deleteBranch")]
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
                @livewire('settings.card', [
                    'id' => $branch->id,
                    'title' => $branch->name,
                    'details' => $branch->location,
                    'editUrl' => route('branches.edit', ['id' => $branch->id]),
                    'deleteAction' => "deleteBranch",
                ], key($branch->id))
            </div>
        @endforeach
    </div>
</div>