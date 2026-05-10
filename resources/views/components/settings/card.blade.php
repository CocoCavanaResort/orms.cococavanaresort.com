<?php

use Livewire\Component;

new class extends Component
{
    public $id;
    public $title;
    public $subtitle;
    public $details;
    public $editUrl;
    public $deleteAction;

    public function mount($id, $title, $details, $editUrl, $deleteAction, $subtitle = null)
    {
        $this->id = $id;
        $this->title = $title;
        $this->subtitle = $subtitle;
        $this->details = $details;
        $this->editUrl = $editUrl;
        $this->deleteAction = $deleteAction;
    }

    function deleteAction()
    {
        $this->emit($this->deleteAction);
    }
};
?>

<div class="card h-100 mw-100 shadow-sm">
    <div class="card-body">
        <h5 class="card-title m-0">{{ $this->title }} @if($this->subtitle)<small>({{ $this->subtitle }})</small>@endif</h5>
        <p class="card-text small" style="text-overflow: wrap;">{{ $this->details }}</p>
    </div>
    <div class="card-footer d-flex justify-content-end gap-2">
        <a href="{{ $this->editUrl }}" class="btn btn-sm btn-primary" wire:navigate>Edit</a>
        <button class="btn btn-sm btn-danger" wire:click="$dispatch('{{ $this->deleteAction }}', { id: {{ $this->id }} })" wire:confirm="Are you sure you want to delete this user?">Delete</button>
    </div>
</div>