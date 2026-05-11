<?php

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Models\User;
use Livewire\Attributes\On;

new #[Layout('layouts::panel', ['title' => 'Users'])] class extends Component
{
    public $search = '';
    
    public function with(): array
    {
        return [
            'users' => User::where(function ($query) {
                    $query->where('name', 'like', '%' . $this->search . '%')
                        ->orWhere('email', 'like', '%' . $this->search . '%');
                })
                ->whereKeyNot(1) // Exclude super admin
                ->whereKeyNot(auth()->id()) // Exclude current user
                ->with('roles')
                ->get(),
        ];
    }

    public function loadUser($userId)
    {
        return redirect()->route('users.edit', ['id' => $userId]);
    }

    #[On("deleteUser")]
    public function deleteUser($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        session()->flash('success', 'User deleted successfully.');
    }
};
?>

<div class="d-grid h-100 w-100 gap-3" style="grid-template-rows: auto 1fr;">
    <div class="d-flex justify-content-between align-items-center px-2">
        <h6 class="mb-0">Users</h6>
        <input type="search" class="form-control form-control-sm" placeholder="Search users..." wire:model.live="search" />
    </div>
    <div class="d-flex flex-column gap-3" style="overflow-y: auto;">
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-3">
            @foreach ($users as $user)
                <div class="col">
                    @livewire('settings.card', [
                        'id' => $user->id,
                        'title' => $user->name,
                        'subtitle' => $user->roles->pluck('name')->join(', '),
                        'details' => $user->email,
                        'editUrl' => route('users.edit', ['id' => $user->id]),
                        'deleteAction' => "deleteUser",
                    ], key($user->id))
                </div>
            @endforeach
        </div>
    </div>
    <a href="{{ route('users.add') }}" class="btn btn-sm btn-primary" wire:navigate>Add User</a>
</div>