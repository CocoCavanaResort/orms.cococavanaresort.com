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
<div class="wrapper">
    {{ $slot }}
</div>
@endsection