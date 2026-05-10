<?php

use Livewire\Component;
use Livewire\Attributes\Layout;

new #[Layout('layouts::panel', ['title' => 'Edit Role'])] class extends Component
{
    public $name;
    public $permissions = [];
    public $roleId;

    public function mount($id)
    {
        $role = \Spatie\Permission\Models\Role::findById($id);
        $this->roleId = $id;
        $this->name = $role->name;
        $this->permissions = $role->permissions()->pluck('name')->toArray();
    }

    public function updateRole()
    {
        // Validate input
        $this->validate([
            'name' => 'required|string|max:255|unique:roles,name,' . $this->roleId,
            'permissions' => 'array',
            'permissions.*' => 'exists:permissions,name',
        ]);

        // Update role
        $role = \Spatie\Permission\Models\Role::findById($this->roleId);
        $role->name = $this->name;
        $role->save();

        // Sync permissions
        $role->syncPermissions($this->permissions);

        // Redirect to roles list or show success message
        return redirect()->route('roles-and-permissions');
    }
};
?>

<div class="container-fluid">
    <form wire:submit.prevent="updateRole">
        <div class="mb-3">
            <label for="name @error('name') text-danger @enderror" class="form-label">Role Name</label>
            <input type="text" class="form-control" id="name" wire:model="name">
            @error('name') <span class="text-danger">{{ $message }}</span> @enderror
        </div>
        <div class="mb-3">
            <label for="permissions" class="form-label">Permissions</label>
            <div class="d-grid gap-1" id="permissions">
                 @error('permissions') <span class="text-danger">{{ $message }}</span> @enderror
                 @foreach (\Spatie\Permission\Models\Permission::all() as $permission)
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="{{ $permission->name }}" id="permission-{{ $permission->name }}" wire:model="permissions">
                        <label class="form-check-label" for="permission-{{ $permission->name }}">
                            {{ $permission->name }}
                        </label>
                        @error('permissions.' . $loop->index) <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                @endforeach
            </div>
            @error('permissions') <span class="text-danger">{{ $message }}</span> @enderror
        </div>
        <button type="submit" class="btn btn-primary">Update Role</button>
    </form>
</div>