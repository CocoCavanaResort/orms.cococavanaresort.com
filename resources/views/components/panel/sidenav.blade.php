<?php

use Livewire\Component;

new class extends Component
{
    //
};
?>

<aside id="sidenav">
    <header class="d-flex justify-content-between align-items-center p-3">
        <h6 class="m-0">{{ config('app.name') }}</h6>
        <button class="btn btn-ghost sidenav-toggle">
            <i class="fa-solid fa-xmark"></i>
        </button>
    </header>
    <nav class="overflow-scroll">
        <div class="d-flex flex-column">
            <a class="nav-link" href="{{ route('dashboard') }}" wire:navigate wire:current="active">
                <i class="fa-solid fa-home"></i>
                Dashboard
            </a>
    
            @role(['booking', 'admin', 'superadmin'])
            <!-- Booking -->
            <a class="nav-link collapsed" data-bs-toggle="collapse" href="#bookingMenu" role="button" aria-expanded="false" aria-controls="bookingMenu">
                <i class="fa-solid fa-book"></i>
                Booking
            </a>
            <div class="collapse ps-3" id="bookingMenu">
                <a class="nav-link" href="#">
                    <i class="fa-solid fa-calendar-check"></i>
                    Reservations
                </a>
                <a class="nav-link" href="#">
                    <i class="fa-solid fa-bed"></i>
                    Rooms
                </a>
                <a class="nav-link" href="#">
                    <i class="fa-solid fa-users"></i>
                    Customers
                </a>
                <a class="nav-link" href="#">
                    <i class="fa-solid fa-file-invoice-dollar"></i>
                    Invoices
                </a>
            </div>
            @endrole
    
            @role(['frontdesk', 'admin', 'superadmin'])
            <!-- Front Desk -->
            <a class="nav-link collapsed" data-bs-toggle="collapse" href="#frontDeskMenu" role="button" aria-expanded="false" aria-controls="frontDeskMenu">
                <i class="fa-solid fa-concierge-bell"></i>
                Front Desk
            </a>
            <div class="collapse ps-3" id="frontDeskMenu">
                <a class="nav-link" href="#">
                    <i class="fa-solid fa-clipboard-list"></i>
                    Check-Ins
                </a>
                <a class="nav-link" href="#">
                    <i class="fa-solid fa-clipboard-check"></i>
                    Check-Outs
                </a>
                <a class="nav-link" href="#">
                    <i class="fa-solid fa-receipt"></i>
                    Billing
                </a>
            </div>
            @endrole
    
            @role(['housekeeping', 'admin', 'superadmin'])
            <!-- Housekeeping -->
            <a class="nav-link collapsed" data-bs-toggle="collapse" href="#housekeepingMenu" role="button" aria-expanded="false" aria-controls="housekeepingMenu">
                <i class="fa-solid fa-broom"></i>
                Housekeeping
            </a>
            <div class="collapse ps-3" id="housekeepingMenu">
                <a class="nav-link" href="#">
                    <i class="fa-solid fa-bed"></i>
                    Room Status
                </a>
                <a class="nav-link" href="#">
                    <i class="fa-solid fa-tasks"></i>
                    Cleaning Schedule
                </a>
                <a class="nav-link" href="#">
                    <i class="fa-solid fa-users"></i>
                    Staff
                </a>
            </div>
            @endrole
    
            @role(['hr', 'admin', 'superadmin'])
            <a class="nav-link collapsed" data-bs-toggle="collapse" href="#hrMenu" role="button" aria-expanded="false" aria-controls="hrMenu">
                <i class="fa-solid fa-users"></i>
                Human Resources
            </a>
            <div class="collapse ps-3" id="hrMenu">
                <a class="nav-link" href="#">
                    <i class="fa-solid fa-user"></i>
                    Employees
                </a>
    
                <a class="nav-link" href="#">
                    <i class="fa-solid fa-calendar-alt"></i>
                    Attendance
                </a>
    
                <a class="nav-link" href="#">
                    <i class="fa-solid fa-money-check-dollar"></i>
                    Payroll
                </a>
    
                <a class="nav-link collapsed" data-bs-toggle="collapse" href="#deductionsMenu" role="button" aria-expanded="false" aria-controls="deductionsMenu">
                    <i class="fa-solid fa-file-invoice-dollar"></i>
                    Deductions
                </a>
                <div class="collapse ps-3" id="deductionsMenu">
                    <a class="nav-link" href="#">
                        <i class="fa-solid fa-hand-holding-dollar"></i>
                        Loans
                    </a>
    
                    <a class="nav-link collapsed" data-bs-toggle="collapse" href="#governmentBenefitsMenu" role="button" aria-expanded="false" aria-controls="governmentBenefitsMenu">
                        <i class="fa-solid fa-landmark"></i>
                        Government Benefits
                    </a>
                    <div class="collapse ps-3" id="governmentBenefitsMenu">
                        <a class="nav-link" href="#">
                            <i class="fa-solid fa-shield-alt"></i>
                            SSS
                        </a>
                        <a class="nav-link" href="#">
                            <i class="fa-solid fa-heartbeat"></i>
                            PhilHealth
                        </a>
                        <a class="nav-link" href="#">
                            <i class="fa-solid fa-building-columns"></i>
                            Pag-IBIG
                        </a>
                    </div>
                </div>
    
                <a class="nav-link collapsed" data-bs-toggle="collapse" href="#leavesMenu" role="button" aria-expanded="false" aria-controls="leavesMenu">
                    <i class="fa-solid fa-calendar-day"></i>
                    Leaves
                </a>
                <div class="collapse ps-3" id="leavesMenu">
                    <a class="nav-link" href="#">
                        <i class="fa-solid fa-briefcase"></i>
                        Vacation Leave
                    </a>
                    <a class="nav-link" href="#">
                        <i class="fa-solid fa-briefcase"></i>
                        Sick Leave
                    </a>
                    <a class="nav-link" href="#">
                        <i class="fa-solid fa-briefcase"></i>
                        Other Leaves
                    </a>
                </div>
    
                <a class="nav-link collapsed" data-bs-toggle="collapse" href="#benefitsMenu" role="button" aria-expanded="false" aria-controls="benefitsMenu">
                    <i class="fa-solid fa-gift"></i>
                    Benefits
                </a>
                <div class="collapse ps-3" id="benefitsMenu">
                    <a class="nav-link" href="#">
                        <i class="fa-solid fa-gift"></i>
                        Holiday Pay
                    </a>
                    <a class="nav-link" href="#">
                        <i class="fa-solid fa-gift"></i>
                        13th Month Pay
                    </a>
                    <a class="nav-link" href="#">
                        <i class="fa-solid fa-gift"></i>
                        Other Benefits
                    </a>
                </div>
            </div>
            @endrole
    
            @role(['reporting', 'admin', 'superadmin'])
            <!-- Reporting -->
            <a class="nav-link collapsed" data-bs-toggle="collapse" href="#reportingMenu" role="button" aria-expanded="false" aria-controls="reportingMenu">
                <i class="fa-solid fa-chart-line"></i>
                Reporting
            </a>
            <div class="collapse ps-3" id="reportingMenu">
                <a class="nav-link" href="#">
                    <i class="fa-solid fa-chart-pie"></i>
                    Occupancy Report
                </a>
                <a class="nav-link" href="#">
                    <i class="fa-solid fa-chart-bar"></i>
                    Revenue Report
                </a>
                <a class="nav-link" href="#">
                    <i class="fa-solid fa-chart-area"></i>
                    Customer Report
                </a>
            </div>
            @endrole
    
            @role(['admin', 'superadmin'])
            <!-- Property Management -->
            <a class="nav-link collapsed" data-bs-toggle="collapse" href="#propertyManagementMenu" role="button" aria-expanded="false" aria-controls="propertyManagementMenu">
                <i class="fa-solid fa-building"></i>
                Property Management
            </a>
            <div class="collapse ps-3" id="propertyManagementMenu">
                <a class="nav-link" href="#">
                    <i class="fa-solid fa-cogs"></i>
                    General Settings
                </a>
                <a class="nav-link" href="#">
                    <i class="fa-solid fa-code-branch"></i>
                    Branches
                </a>
            </div>
            @endrole
    
            @role('superadmin')
            <!-- System Settings -->
            <a class="nav-link collapsed" data-bs-toggle="collapse" href="#systemSettingsMenu" role="button" aria-expanded="false" aria-controls="systemSettingsMenu">
                <i class="fa-solid fa-gear"></i>
                System Settings
            </a>
            <div class="collapse ps-3" id="systemSettingsMenu">
                <a class="nav-link" href="{{ route('users') }}" wire:navigate wire:current="active">
                    <i class="fa-solid fa-user-cog"></i>
                    User Management
                </a>
                <a class="nav-link" href="#">
                    <i class="fa-solid fa-shield-halved"></i>
                    Roles & Permissions
                </a>
            </div>
            @endrole
        </div>
    </nav>
    @script
    <script>
        $(function () {
            $('.sidenav-toggle').on('click', function () {
                $('#sidenav').toggleClass('active');
            });
        });
    </script>
    @endscript
</aside>