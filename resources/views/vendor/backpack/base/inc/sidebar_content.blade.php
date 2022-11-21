{{-- This file is used to store sidebar items, inside the Backpack admin panel --}}
<li class="nav-item"><a class="nav-link" href="{{ backpack_url('dashboard') }}"><i class="la la-home nav-icon"></i> {{ trans('backpack::base.dashboard') }}</a></li>

<li class="nav-item"><a class="nav-link" href="{{ backpack_url('invoice') }}"><i class="nav-icon la la-cash-register"></i> Invoices</a></li>
<!-- <li class="nav-item"><a class="nav-link" href="{{ backpack_url('invoice-group') }}"><i class="nav-icon la la-print"></i> Invoice groups</a></li> -->
<li class="nav-item"><a class="nav-link" href="{{ backpack_url('naik-kelas') }}"><i class="nav-icon la la-sort-amount-up"></i> Naik Kelas</a></li>
<!-- <li class="nav-item"><a class="nav-link" href="{{ backpack_url('payment') }}"><i class="nav-icon la la-cash-register"></i> Payments</a></li> -->
<!-- Petty cash -->
<!-- <li class="nav-item nav-dropdown">
    <a class="nav-link nav-dropdown-toggle" href="#"><i class="nav-icon la la-money"></i> Petty Cashes</a>
    <ul class="nav-dropdown-items">
        <li class="nav-item"><a class="nav-link" href="{{ backpack_url('petty-cash/PettyCashCostum') }}"><i class="nav-icon la la-money"></i> Petty Cashes</a></li>
        <li class="nav-item"><a class="nav-link" href="{{ backpack_url('petty-cash') }}"><i class="nav-icon la la-money"></i> Petty Cashes Master</a></li>
    </ul>
</li> -->
<li class="nav-item"><a class="nav-link" href="{{ backpack_url('petty-cash') }}"><i class="nav-icon la la-money"></i> Petty Cashes</a></li>
<li class="nav-item nav-dropdown">
    <a class="nav-link nav-dropdown-toggle" href="#"><i class="nav-icon la la-user-graduate"></i> Students</a>
    <ul class="nav-dropdown-items">
        <li class="nav-item"><a class="nav-link" href="{{ backpack_url('student') }}"><i class="nav-icon la la-user-graduate"></i> All</a></li>
        <li class="nav-item"><a class="nav-link" href="{{ backpack_url('student-funding-detail') }}"><i class="nav-icon la la-hand-holding-usd"></i> funding details</a></li>
        <li class="nav-item"><a class="nav-link" href="{{ backpack_url('student-school-history') }}"><i class="nav-icon la la-history"></i> school histories</a></li>
    </ul>
</li>
<!-- Setting -->
<li class="nav-item nav-dropdown">
    <a class="nav-link nav-dropdown-toggle" href="#"><i class="nav-icon la la-cog"></i> Setting Master Data</a>
    <ul class="nav-dropdown-items">
        <li class="nav-item"><a class="nav-link" href="{{ backpack_url('setting') }}"><i class="nav-icon la la-cog"></i> Settings</a></li>
        <li class="nav-item"><a class="nav-link" href="{{ backpack_url('school-year') }}"><i class="nav-icon la la-school"></i> School years</a></li>
        <li class="nav-item"><a class="nav-link" href="{{ backpack_url('school-level') }}"><i class="nav-icon la la-graduation-cap"></i> School levels</a></li>
        <li class="nav-item"><a class="nav-link" href="{{ backpack_url('spp-master') }}"><i class="nav-icon la la-money-bill"></i> Spp masters</a></li>
        <li class="nav-item"><a class="nav-link" href="{{ backpack_url('payment-way') }}"><i class="nav-icon la la-credit-card"></i> Payment ways</a></li>
        <li class="nav-item"><a class="nav-link" href="{{ backpack_url('classroom') }}"><i class="nav-icon la la-chalkboard"></i> Classrooms</a></li>
        <li class="nav-item"><a class="nav-link" href="{{ backpack_url('teacher') }}"><i class="nav-icon la la-chalkboard-teacher"></i> Teachers</a></li>
        <!-- <li class="nav-item"><a class="nav-link" href="{{ backpack_url('teacher-classroom') }}"><i class="nav-icon la la-hashtag"></i> Teacher classrooms</a></li> -->
    </ul>
</li>
<!-- Setting -->
<!-- Report -->
<li class="nav-item nav-dropdown">
    <a class="nav-link nav-dropdown-toggle" href="#"><i class="nav-icon la la-print"></i> Report</a>
    <ul class="nav-dropdown-items">
        <li class="nav-item"><a class="nav-link" href="{{ backpack_url('report/petty-cash') }}"><i class="nav-icon la la-print"></i> Kas Masuk</a></li>
        <!-- <li class="nav-item"><a class="nav-link" href="{{ backpack_url('school-year') }}"><i class="nav-icon la la-school"></i> School years</a></li> -->
    </ul>
</li>
<!-- Report -->
<!-- <li class="nav-item"><a class="nav-link" href="{{ backpack_url('classroom') }}"><i class="nav-icon la la-question"></i> Classrooms</a></li>
<li class="nav-item"><a class="nav-link" href="{{ backpack_url('payment') }}"><i class="nav-icon la la-question"></i> Payments</a></li>
<li class="nav-item"><a class="nav-link" href="{{ backpack_url('payment-way') }}"><i class="nav-icon la la-question"></i> Payment ways</a></li>
<li class="nav-item"><a class="nav-link" href="{{ backpack_url('petty-cash') }}"><i class="nav-icon la la-question"></i> Petty cashes</a></li>
<li class="nav-item"><a class="nav-link" href="{{ backpack_url('school-level') }}"><i class="nav-icon la la-question"></i> School levels</a></li>
<li class="nav-item"><a class="nav-link" href="{{ backpack_url('school-year') }}"><i class="nav-icon la la-question"></i> School years</a></li>
<li class="nav-item"><a class="nav-link" href="{{ backpack_url('setting') }}"><i class="nav-icon la la-question"></i> Settings</a></li>
<li class="nav-item"><a class="nav-link" href="{{ backpack_url('spp-master') }}"><i class="nav-icon la la-question"></i> Spp masters</a></li>
<li class="nav-item"><a class="nav-link" href="{{ backpack_url('student') }}"><i class="nav-icon la la-question"></i> Students</a></li>
<li class="nav-item"><a class="nav-link" href="{{ backpack_url('teacher') }}"><i class="nav-icon la la-question"></i> Teachers</a></li> -->
<!-- <li class="nav-item"><a class="nav-link" href="{{ backpack_url('teacher-classroom') }}"><i class="nav-icon la la-question"></i> Teacher classrooms</a></li> -->

<!-- <li class="nav-item"><a class="nav-link" href="{{ backpack_url('invoice') }}"><i class="nav-icon la la-question"></i> Invoices</a></li> -->
<!-- <li class="nav-item"><a class="nav-link" href="{{ backpack_url('student-funding-detail') }}"><i class="nav-icon la la-question"></i> Student funding details</a></li>
<li class="nav-item"><a class="nav-link" href="{{ backpack_url('student-school-history') }}"><i class="nav-icon la la-question"></i> Student school histories</a></li> -->