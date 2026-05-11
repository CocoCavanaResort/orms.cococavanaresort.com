<?php

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Models\Property\Branch;
use Livewire\Attributes\On;

new #[Layout('layouts::panel', ['title' => 'Branches'])] class extends Component
{
    public $search = '';
    
    public function with(): array
    {
        return [
            'branches' => Branch::where('name', 'like', "%{$this->search}%")->get(),
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

<div class="d-grid h-100 w-100 gap-3" style="grid-template-rows: auto 1fr auto;">
    <div class="d-flex justify-content-between align-items-center px-2">
        <h4 class="mb-0">Branches</h4>
        <div>
            <input type="text" class="form-control" placeholder="Search branches..." wire:model.live="search">
        </div>
    </div>
    <div class="d-flex flex-column gap-3" style="overflow-y: auto;">
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
    <a href="{{ route('branches.add') }}" class="btn btn-primary" wire:navigate>Add Branch</a>
</div>