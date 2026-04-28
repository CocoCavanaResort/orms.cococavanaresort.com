<?php

use Livewire\Component;
use Livewire\Attributes\Layout;

new #[Layout('layouts.app')] class extends Component
{
    //
};
?>

@extends('layouts.app')

@section('content')
    @livewire('panel.topnav')
    @livewire('panel.sidenav')
    <main>
        {{ $slot }}
    </main>
@endsection