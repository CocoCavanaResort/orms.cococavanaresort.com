<?php

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Models\Property\Room;
use App\Models\Property\Branch;
use Livewire\Attributes\On;

new #[Layout('layouts::panel', ['title' => 'Rooms'])] class extends Component
{
    public $search = '';
    public $branch_id;

    public function mount()
    {
        $this->branch_id = auth()->user()->isSuperAdmin() ? null : auth()->user()->branch_id;
    }

    #[On("deleteRoom")]
    public function deleteRoom($id)
    {
        $room = Room::findOrFail($id);
        $room->delete();

        session()->flash('success', 'Room deleted successfully.');
    }

    public function with(): array
    {
        return [
            'rooms' => Room::where('name', 'like', "%{$this->search}%")
                ->when($this->branch_id, function ($query) {
                    $query->where('branch_id', $this->branch_id);
                })
                ->get(),
            'branches' => Branch::all(),
        ];
    }
};
?>

<div class="container-fluid">
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-2">
        <a href="{{ route('rooms.add') }}" class="btn btn-sm btn-primary" wire:navigate>Add Room</a>
        <div class="d-flex align-items-center gap-2">
            <input type="text" class="form-control form-control-sm" placeholder="Search rooms..." wire:model.live="search">
            @if (auth()->user()->isSuperAdmin())
            <select class="form-select form-select-sm" wire:model.live="branch_id">
                <option value="">All Branches</option>
                @foreach ($branches as $branch)
                    <option value="{{ $branch->id }}">{{ $branch->name }}</option>
                @endforeach
            </select>
            @endif
        </div>
    </div>
    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-3">
        @foreach ($rooms as $room)
            <div class="col">
                @livewire('settings.card', [
                    'id' => $room->id,
                    'title' => $room->name,
                    'subtitle' => $room->capacity . ' pax',
                    'details' => number_format($room->price, 2) . ' PHP/night',
                    'editUrl' => route('rooms.edit', ['id' => $room->id]),
                    'deleteAction' => "deleteRoom",
                ], key($room->id))
            </div>
        @endforeach
    </div>
</div>