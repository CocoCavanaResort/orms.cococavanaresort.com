<?php

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Models\User;

new #[Layout('layouts::panel', ['title' => 'Edit User'])] class extends Component
{
    public $user;
    public $username;
    public $email;
    public $password;

    public function mount($id)
    {
        $user = User::findOrFail($id);
        $this->user = $user;
        $this->username = $user->name;
        $this->email = $user->email;
    }

    public function update(User $user) {
        // Validate input
        $this->validate([
            'username' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8',
        ]);

        // Update user
        $user->name = $this->username;
        $user->email = $this->email;
        if ($this->password) {
            $user->password = bcrypt($this->password);
        }
        $user->save();

        // Redirect to users list or show success message
        return redirect()->route('users');
    }
};
?>

<div class="container">
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
        <button type="submit" class="btn btn-primary">Update User</button>
    </form>
</div>