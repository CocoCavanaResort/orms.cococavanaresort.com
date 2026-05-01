<?php

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Models\User;

new #[Layout('layouts::panel', ['title' => 'Add User'])] class extends Component
{
    public $username;
    public $email;
    public $password;

    public function addUser()
    {
        // Validate input
        $this->validate([
            'username' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
        ]);

        // Create user
        $user = User::create([
            'name' => $this->username,
            'email' => $this->email,
            'password' => bcrypt($this->password),
        ]);

        // Redirect to users list or show success message
        return redirect()->route('users');
    }
};
?>

<div class="container">
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
        <div class="mb-3">
            <label for="password @error('password') text-danger @enderror" class="form-label">Password</label>
            <input type="password" class="form-control" id="password" wire:model="password">
            @error('password') <span class="text-danger">{{ $message }}</span> @enderror
        </div>
        <button type="submit" class="btn btn-primary">Add User</button>
    </form>
</div>