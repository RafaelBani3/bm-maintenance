
{{-- Sidebar --}}
<nav class="sidebar sidebar-offcanvas "  id="sidebar">
    
    {{-- Menu Links --}}
    <ul class="nav" style="color: white;">
        {{-- Menu 1 --}}
        <li class="nav-item" style="color: white;">
            <a class="nav-link" href="{{ route('Dashboard') }}">
                <i class="icon-grid menu-icon"></i>
                <span class="menu-title text-white">Dashboard</span>
            </a>
        </li>

        {{-- Menu 2 --}}
        @if(auth()->user()->hasAnyPermission(['view dashboard', 'view cr']))
        <li class="nav-item">
            <div class="nav-link" data-bs-toggle="collapse" href="#case-report" aria-expanded="false" aria-controls="ui-basic">
                <i class="icon-layout menu-icon"></i>
                <span class="menu-title text-white">Case Report</span>
                <i class="menu-arrow"></i>
            </div>
            {{-- Submenu 2 --}}
            <div class="collapse" id="case-report">
                <ul class="nav flex-column sub-menu text-white">
                    <li class="nav-item"> <a class="nav-link" href="{{ route('CreateCase') }}">Create</a></li>
                    <li class="nav-item"> <a class="nav-link" href="{{ route('ViewCase') }}">List</a></li>
                    <li class="nav-item"> <a class="nav-link" href="{{ route('ApprovalCase') }}">Approval</a></li>
                </ul>
            </div>
        </li>
        @endif

        {{-- Menu 3 --}}
        @if(auth()->user()->hasAnyPermission(['view cr', 'view cr_ap']))
        <li class="nav-item">
            <div class="nav-link" data-bs-toggle="collapse" href="#wo" aria-expanded="false" aria-controls="ui-basic">
                <i class="icon-layout menu-icon"></i>
                <span class="menu-title">Work Order</span>
                <i class="menu-arrow"></i>
            </div>
            {{-- Submenu 3 --}}
            <div class="collapse" id="wo">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item"> <a class="nav-link" href="../pages/ui-features/buttons.html">Create</a></li>
                    <li class="nav-item"> <a class="nav-link" href="../pages/ui-features/dropdowns.html">List</a></li>
                </ul>
            </div>
        </li>
        @endif

        {{-- Menu 4 --}}
        @if(auth()->user()->hasAnyPermission(['view mr', 'approval mr_ap']))
        <li class="nav-item">
            <div class="nav-link" data-bs-toggle="collapse" href="#mr" aria-expanded="false" aria-controls="ui-basic">
                <i class="icon-layout menu-icon"></i>
                <span class="menu-title">Material Request</span>
                <i class="menu-arrow"></i>
            </div>
            {{-- Submenu 4 --}}
            <div class="collapse" id="mr">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item"> <a class="nav-link" href="../pages/ui-features/buttons.html">Create</a></li>
                    <li class="nav-item"> <a class="nav-link" href="../pages/ui-features/dropdowns.html">List</a></li>
                    <li class="nav-item"> <a class="nav-link" href="../pages/ui-features/dropdowns.html">Approval</a></li>
                </ul>
            </div>
        </li>
        @endif

        {{-- Menu 5 --}}
        @if(auth()->user()->hasAnyPermission(['view woc', 'approval woc']))
        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="collapse" href="#woc" aria-expanded="false" aria-controls="ui-basic">
                <i class="icon-layout menu-icon"></i>
                <span class="menu-title">Work Order Completion</span>
                <i class="menu-arrow"></i>
            </a>
            {{-- Submenu 4 --}}
            <div class="collapse" id="woc">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item"> <a class="nav-link" href="../pages/ui-features/buttons.html">Create</a></li>
                    <li class="nav-item"> <a class="nav-link" href="../pages/ui-features/dropdowns.html">List</a></li>
                    <li class="nav-item"> <a class="nav-link" href="../pages/ui-features/dropdowns.html">Approval</a></li>
                </ul>
            </div>
        </li>
        @endif


   
    </ul>
    {{-- End Menu --}}
  </nav>