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
<link rel="stylesheet" href="/src/css/auth.min.css">
@endpush

@section('content')
<div class="wrapper">
    {{ $slot }}
</div>
@endsection