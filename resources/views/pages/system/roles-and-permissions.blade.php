<?php

use Livewire\Component;
use Livewire\Attributes\Layout;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

new #[Layout('layouts::panel', ['title' => 'Roles and Permissions'])] class extends Component
{
    public function with(): array
    {
        return [
            'roles' => Role::all()->except(["Super Admin"]), // Fetch all roles except "Super Admin"
            'permissions' => Permission::all(), // Fetch all permissions
        ];
    }

    public function deleteRole($id)
    {
        $role = Role::findById($id);
        $role->delete();
    }
};
?>

<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <a href="{{ route('roles.add') }}" class="btn btn-primary" wire:navigate>Add Role</a>
    </div>
    <div class="d-flex flex-column gap-3">
        @foreach ($roles as $role)
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="card-title m-0">{{ $role->name }}</h5>
                            {{-- First 3 permissions then ... --}}
                            <p class="card-text small">
                                {{ $role->permissions->pluck('name')->take(3)->join(', ') }}
                                @if ($role->permissions->count() > 3)
                                    ... ({{ $role->permissions->count() }} total)
                                @elseif($role->permissions->count() === 0)
                                    No permissions assigned
                                @endif
                            </p>
                        </div>
                        <div>
                            <a href="{{ route('roles.edit', ['id' => $role->id]) }}" class="btn btn-primary" wire:navigate>Edit</a>
                            <button class="btn btn-danger" wire:click="deleteRole({{ $role->id }})" wire:confirm="Are you sure you want to delete this role?">Delete</button>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>