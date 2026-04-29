<?php

use Livewire\Component;

new class extends Component
{
    public string $title = '';

    public function mount($title)
    {
        $this->title = $title;
    }
};
?>

<header class="topnav navbar navbar-expand-lg navbar-light d-flex align-items-center">
    <div class="container-fluid">
        <button class="btn btn-ghost sidenav-toggle">
            <i class="fa-solid fa-bars"></i>
        </button>
        <h5 class="navbar-brand mb-0">{{ $title }}</h5>
        <div class="navbar-nav">
            <div class="nav-item dropdown">
                <a class="nav-link" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fa-solid fa-user"></i>
                </a>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li><a class="dropdown-item" href="#">Profile</a></li>
                    <li><a class="dropdown-item" href="#">Settings</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item" href="{{ route('logout') }}">Logout</a></li>
                </ul>
            </div>
        </div>
    </div>
</header>