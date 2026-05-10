<?php

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Models\Property\Room;
use App\Models\Property\Branch;

new #[Layout('layouts::panel', ['title' => 'Rooms'])] class extends Component
{
    public $search = '';
    public $branch_id;

    public function mount()
    {
        $this->branch_id = auth()->user()->isSuperAdmin() ? null : auth()->user()->branch_id;
    }

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
    <div class="d-flex justify-content-between align-items-center mb-4">
        <a href="{{ route('rooms.add') }}" class="btn btn-primary" wire:navigate>Add Room</a>
        <div class="d-flex align-items-center gap-2">
            <input type="text" class="form-control" placeholder="Search rooms..." wire:model.live="search">
            @if (auth()->user()->isSuperAdmin())
            <select class="form-select" wire:model.live="branch_id">
                <option value="">All Branches</option>
                @foreach ($branches as $branch)
                    <option value="{{ $branch->id }}">{{ $branch->name }}</option>
                @endforeach
            </select>
            @endif
        </div>
    </div>
    <div class="d-flex flex-column gap-3">
        @foreach ($rooms as $room)
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="card-title m-0">{{ $room->name }}</h5>
                            <p class="card-text small">{{ $room->branch->name }}</p>
                        </div>
                        <div>
                            <a href="{{ route('rooms.edit', ['id' => $room->id]) }}" class="btn btn-primary" wire:navigate>Edit</a>
                            <button class="btn btn-danger" wire:click="deleteRoom({{ $room->id }})" wire:confirm="Are you sure you want to delete this room?">Delete</button>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>