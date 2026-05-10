<?php

use Livewire\Component;
use Livewire\Attributes\Layout;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Livewire\Attributes\On;

new #[Layout('layouts::panel', ['title' => 'Roles and Permissions'])] class extends Component
{
    public function with(): array
    {
        return [
            'roles' => Role::where('id', '!=', 1)->get(), // Fetch all roles except "Super Admin"
            'permissions' => Permission::all(), // Fetch all permissions
        ];
    }

    #[On("deleteRole")]
    public function deleteRole($id)
    {
        $role = Role::findById($id);
        $role->delete();
        session()->flash('success', 'Role deleted successfully.');
    }
};
?>

<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <a href="{{ route('roles.add') }}" class="btn btn-primary" wire:navigate>Add Role</a>
    </div>
    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-3">
        @foreach ($roles as $role)
            <div class="col">
                @php
                    $details = $role->permissions->pluck('name')->take(3)->join(', ') ?: 'No permissions assigned';
                    if ($role->permissions->count() > 3) {
                        $details .= '...';
                    }
                @endphp
                @livewire('settings.card', [
                    'id' => $role->id,
                    'title' => $role->name,
                    'details' => $details,
                    'editUrl' => route('roles.edit', ['id' => $role->id]),
                    'deleteAction' => "deleteRole",
                ], key($role->id))
            </div>
        @endforeach
    </div>
</div>