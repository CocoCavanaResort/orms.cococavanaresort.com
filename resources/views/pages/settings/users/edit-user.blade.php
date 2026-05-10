<?php

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Models\User;
use Spatie\Permission\Models\Role;
use App\Models\Property\Branch;

new #[Layout('layouts::panel', ['title' => 'Edit User'])] class extends Component
{
    public $user;
    public $username;
    public $email;
    public $password;
    public $role;
    public $branch;

    public function mount($id)
    {
        $user = User::findOrFail($id);
        $this->user = $user;
        $this->username = $user->name;
        $this->email = $user->email;
        $this->role = $user->roles->first()?->id;
        $this->branch = $user->branch_id;
    }

    public function with(): array
    {
        return [
            'roles' => Role::whereNot('name', 'Super Admin')->get(), // exclude "Super Admin" role from the list
            'branches' => Branch::all(),
        ];
    }

    public function update(User $user) {
        // Validate input
        $this->validate([
            'username' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8',
            'role' => 'required|exists:roles,id',
            'branch' => 'required|exists:branches,id',
        ]);

        // Update user
        $user->name = $this->username;
        $user->email = $this->email;
        $user->branch_id = $this->branch;
        $user->syncRoles(Role::findById($this->role)->name); // Sync the selected role
        if ($this->password) {
            $user->password = bcrypt($this->password);
        }
        $user->save();

        session()->flash('success', 'User updated successfully.');
        // Redirect to users list or show success message
        return $this->redirect(route('users'), true);
    }
};
?>

<div class="container-fluid">
    <form wire:submit.prevent="update({{ $user->id }})">
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
        <div class="mb-3">
            <label for="password @error('password') text-danger @enderror" class="form-label">Password (leave blank to keep current)</label>
            <input type="password" class="form-control" id="password" wire:model="password">
            @error('password') <span class="text-danger">{{ $message }}</span> @enderror
        </div>
        <div class="form-check form-switch mb-3">
            <input type="checkbox" class="form-check-input" id="showPassword" onclick="document.getElementById('password').type = this.checked ? 'text' : 'password'">
            <label for="showPassword" class="form-check-label">Show Password</label>
        </div>
        <div class="mb-3">
            <label for="role @error('role') text-danger @enderror" class="form-label">Role</label>
            <select class="form-select" id="role" wire:model="role">
                <option value="">Select a role</option>
                @foreach ($roles as $role)
                    <option value="{{ $role->id }}" {{ $this->role == $role->id ? 'selected' : '' }}>{{ $role->name }}</option>
                @endforeach
            </select>
            @error('role') <span class="text-danger">{{ $message }}</span> @enderror
        </div>
        <div class="mb-3">
            <label for="branch" class="form-label">Branch</label>
            <select class="form-select" id="branch" wire:model="branch">
                <option value="">Select a branch</option>
                @foreach ($branches as $branch)
                    <option value="{{ $branch->id }}" {{ $this->branch == $branch->id ? 'selected' : '' }}>{{ $branch->name }}</option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Update User</button>
    </form>
</div>