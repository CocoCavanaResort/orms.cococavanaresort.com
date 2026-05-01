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
            'users' => User::where('name', 'like', '%' . $this->search . '%')
                ->orWhere('email', 'like', '%' . $this->search . '%')
                ->with('roles')
                ->get(),
        ];
    }

    public function loadUser($userId)
    {
        return redirect()->route('users.edit', ['id' => $userId]);
    }
};
?>

<div class="container">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <a href="{{ route('users.add') }}" class="btn btn-primary" wire:navigate>Add User</a>
        <input type="search" class="form-control w-25" placeholder="Search users..." wire:model.live="search" />
    </div>
    <table class="table">
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Role</th>
            </tr>
        </thead>
        <tbody>
        @foreach ($users as $user)
            <tr wire:click="loadUser({{ $user->id }})" style="cursor: pointer;">
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->roles->pluck('name')->join(', ') }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>