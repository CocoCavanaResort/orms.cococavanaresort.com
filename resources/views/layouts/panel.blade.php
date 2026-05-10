<?php

use Livewire\Component;
use Livewire\Attributes\Layout;

new #[Layout('layouts.app')] class extends Component
{
    //
};
?>

@extends('layouts.app')

@push('styles')
    <link rel="stylesheet" href="/src/css/panel.min.css">
@endpush

@section('content')
    @livewire('panel.topnav', ['title' => $title])
    @livewire('panel.sidenav')
    <main id="app-content">
        {{ $slot }}
        <div class="toast-container position-fixed bottom-0 end-0 p-3">
            @if (session()->has('success'))
                <div class="toast align-items-center text-bg-success border-0 show" role="alert" aria-live="assertive" aria-atomic="true" x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)">
                    <div class="d-flex">
                        <div class="toast-body">
                            {{ session('success') }}
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </main>
@endsection