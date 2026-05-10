<?php

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Models\User;

new #[Layout('layouts::panel', ['title' => 'Users'])] class extends Component
{
    public $search = '';
    
    public function with(): array
    {
        return [
            'users' => User::where(function ($query) {
                    $query->where('name', 'like', '%' . $this->search . '%')
                        ->orWhere('email', 'like', '%' . $this->search . '%');
                })
                ->whereKeyNot(1) // Exclude super admin
                ->whereKeyNot(auth()->id()) // Exclude current user
                ->with('roles')
                ->get(),
        ];
    }

    public function loadUser($userId)
    {
        return redirect()->route('users.edit', ['id' => $userId]);
    }

    public function deleteUser($userId)
    {
        $user = User::findOrFail($userId);
        $user->delete();
        session()->flash('success', 'User deleted successfully.');
    }
};
?>

<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <a href="{{ route('users.add') }}" class="btn btn-primary" wire:navigate>Add User</a>
        <input type="search" class="form-control w-25" placeholder="Search users..." wire:model.live="search" />
    </div>
    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-3">
        @foreach ($users as $user)
            <div class="col">
                <div class="card h-100 shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title m-0">{{ $user->name }} <small>({{ $user->roles->pluck('name')->join(', ') }})</small></h5>
                        <p class="card-text small">{{ $user->email }}</p>
                    </div>
                    <div class="card-footer d-flex justify-content-end gap-2">
                        <a href="{{ route('users.edit', ['id' => $user->id]) }}" class="btn btn-sm btn-primary" wire:navigate>Edit</a>
                        <button class="btn btn-sm btn-danger" wire:click="deleteUser({{ $user->id }})" wire:confirm="Are you sure you want to delete this user?">Delete</button>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>