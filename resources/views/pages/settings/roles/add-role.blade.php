<?php

use Livewire\Component;
use Livewire\Attributes\Layout;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

new #[Layout('layouts::panel', ['title' => 'Add Role'])] class extends Component
{
    public $name;
    public $permissions = [];

    public function addRole()
    {
        // Validate input
        $this->validate([
            'name' => 'required|string|max:255|unique:roles,name',
            'permissions' => 'array',
            'permissions.*' => 'exists:permissions,name',
        ]);

        // Create role
        $role = Role::create(['name' => $this->name]);

        // Sync permissions
        $role->syncPermissions($this->permissions);

        // Redirect to roles list or show success message
        return redirect()->route('roles-and-permissions');
    }
};
?>

<div class="container-fluid">
    <form wire:submit.prevent="addRole">
        <div class="mb-3">
            <label for="name @error('name') text-danger @enderror" class="form-label">Role Name</label>
            <input type="text" class="form-control mb-3" id="name" wire:model="name">
            @error('name') <div class="text-danger">{{ $message }}</div> @enderror
            <label for="permissions" class="form-label">Permissions</label>
            <div class="d-grid gap-1" id="permissions">
                 @error('permissions') <span class="text-danger">{{ $message }}</span> @enderror
                 @foreach (Permission::all() as $permission)
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="{{ $permission->name }}" id="permission-{{ $permission->name }}" wire:model="permissions">
                        <label class="form-check-label" for="permission-{{ $permission->name }}">
                            {{ $permission->name }}
                        </label>
                        @error('permissions.' . $loop->index) <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                @endforeach
            </div>
        </div>
        <button type="submit" class="btn btn-primary">Add Role</button>
    </form>
</div>