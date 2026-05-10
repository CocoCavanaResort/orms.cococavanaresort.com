<?php

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Models\User;
use Spatie\Permission\Models\Role;
use App\Models\Property\Branch;

new #[Layout('layouts::panel', ['title' => 'Add User'])] class extends Component
{
    public $username;
    public $email;
    public $password;
    public $role;
    public $branch;

    public function with() {
        return [
            'branches' => Branch::all(),
            'roles' => Role::whereKeyNot(1)->get(),
        ];
    }

    public function addUser()
    {
        $this->validate([
            'username' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
            'role' => 'required|exists:roles,name',
            'branch' => 'required|exists:branches,id',
        ]);

        $user = User::create([
            'name' => $this->username,
            'email' => $this->email,
            'password' => bcrypt($this->password),
            'branch_id' => $this->branch,
        ]);

        $user->assignRole($this->role);

        session()->flash('success', 'User added successfully.');
        return $this->redirect(route('users'), true);
    }
};
?>

<div class="container-fluid">
    <form wire:submit.prevent="addUser">
        <div class="mb-3">
            <label for="username @error('username') text-danger @enderror" class="form-label">Username</label>
            <input type="text" class="form-control" id="username" wire:model="username">
            @error('username') <span class="text-danger">{{ $message }}</span> @enderror
        </div>
        <div class="mb-3">
            <label for="email @error('email') text-danger @enderror" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" wire:model="email">
            @error('email') <span class="text-danger">{{ $message }}</span> @enderror
        </div>
        <div class="mb-2">
            <label for="password @error('password') text-danger @enderror" class="form-label">Password</label>
            <input type="password" class="form-control" id="password" wire:model="password">
            @error('password') <span class="text-danger">{{ $message }}</span> @enderror
        </div>        
        <div class="form-check form-switch mb-3">
            <input type="checkbox" class="form-check-input" id="showPassword" onclick="document.getElementById('password').type = this.checked ? 'text' : 'password'">
            <label for="showPassword" class="form-check-label">Show Password</label>
        </div>
        <div class="mb-3">
            <label for="role" class="form-label">Role</label>
            <select class="form-select" id="role" wire:model="role">
                <option value="">Select a role</option>
                @foreach ($roles as $role)
                    <option value="{{ $role->name }}">{{ $role->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label for="branch" class="form-label">Branch</label>
            <select class="form-select" id="branch" wire:model="branch">
                <option value="">Select a branch</option>
                @foreach ($branches as $branch)
                    <option value="{{ $branch->id }}">{{ $branch->name }}</option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Add User</button>
    </form>
</div>