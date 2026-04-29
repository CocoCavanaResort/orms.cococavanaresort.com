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
    <main>
        {{ $slot }}
    </main>
@endsection