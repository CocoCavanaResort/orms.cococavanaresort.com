<?php

use Livewire\Component;
use Livewire\Attributes\Layout;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Livewire\Attributes\On;

new #[Layout('layouts::panel', ['title' => 'Roles'])] class extends Component
{
    public $search = '';

    public function with(): array
    {
        return [
            'roles' => Role::where('id', '!=', 1)->where('name', 'like', "%{$this->search}%")->get(), // Fetch all roles except "Super Admin"
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

<div class="d-grid h-100 w-100 gap-3" style="grid-template-rows: auto 1fr auto;">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h6 class="mb-0">Roles & Permissions</h6>
        <input type="search" class="form-control form-control-sm" placeholder="Search roles..." wire:model.live="search" />
    </div>
    <div class="d-flex flex-column gap-3" style="overflow-y: auto;">
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
    <a href="{{ route('roles.add') }}" class="btn btn-sm btn-primary" wire:navigate>Add Role</a>
</div>