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
    <div class="d-flex flex-column gap-3">
        @foreach ($users as $user)
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="card-title m-0">{{ $user->name }} <small>({{ $user->roles->pluck('name')->join(', ') }})</small></h5>
                            <p class="card-text small">{{ $user->email }}</p>
                        </div>
                        <div>
                            <a href="{{ route('users.edit', ['id' => $user->id]) }}" class="btn btn-primary" wire:navigate>Edit</a>
                            <button class="btn btn-danger" wire:click="deleteUser({{ $user->id }})" wire:confirm="Are you sure you want to delete this user?">Delete</button>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>