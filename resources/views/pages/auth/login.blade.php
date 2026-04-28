<?php

use Livewire\Component;
use Livewire\Attributes\Layout;

new #[Layout('layouts.auth', ['title' => 'Login'])] class extends Component
{
    //
};
?>

<div class="card">
    <div class="card-body">
        <h1 class="card-title">Login</h1>
        <form wire:submit.prevent="login">
            <div class="mb-3">
                <label for="email" class="form-label">Email address</label>
                <input type="email" class="form-control" id="email" wire:model.defer="email" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" wire:model.defer="password" required>
            </div>
            <button type="submit" class="btn btn-primary">Login</button>
        </form>
    </div>
</div>