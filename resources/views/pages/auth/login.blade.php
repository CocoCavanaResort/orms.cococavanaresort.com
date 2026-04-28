<?php

use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Validate;

new #[Layout('layouts.auth', ['title' => 'Login'])] class extends Component
{
    #[Validate('required|email')]
    public string $email = '';
    #[Validate('required')]
    public string $password = '';

    public function login()
    {
        $this->validate();
        
        if (Auth::attempt(['email' => $this->email, 'password' => $this->password], true)) {
            session()->regenerate();

            return redirect()->intended('/dashboard');
        }

        $this->addError('email', 'The provided credentials do not match our records.');
        $this->addError('password','The provided credentials do not match our records.');
    }
};
?>

<div class="card">
    <div class="card-body">
        <h5 class="card-title text-center">{{ config('app.name') }}</h5>
        <img src="/src/images/login.png" alt="Logo" width="300">
        @error('email')
            <div class="alert alert-danger small" role="alert">
                {{ $message }}
            </div>
        @enderror
        <form wire:submit.prevent="login" novalidate>
            <div class="mb-3">
                <label for="email" class="form-label">Email address</label>
                <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" wire:model.defer="email" required autofocus>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" wire:model.defer="password" required>
            </div>
            <div class="d-grid">
                <button type="submit" class="btn btn-primary">Login</button>
            </div>
        </form>
    </div>
</div>