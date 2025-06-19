<div class="app-navbar-item ms-1 ms-md-4" id="kt_header_user_menu_toggle">
    <div class="cursor-pointer symbol symbol-40px"
         data-kt-menu-trigger="{default: 'click', lg: 'hover'}" data-kt-menu-attach="parent"
         data-kt-menu-placement="bottom-end">
        <img src="{{ asset('assets/media/avatars/blank.png') }}" class="rounded-circle shadow-sm" alt="user" style="object-fit: cover; width: 40px; height: 40px;" />
    </div>

    <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded shadow-lg border-0 menu-gray-800 menu-state-bg menu-state-color fw-semibold py-5 px-4 fs-6 w-300px"
        data-kt-menu="true">
        
        {{-- Header Profile --}}
        <div class="d-flex align-items-center mb-4">
            <div class="symbol symbol-50px me-4">
                <img src="{{ asset('assets/media/avatars/blank.png') }}" class="rounded-circle shadow" alt="user" />
            </div>
            <div class="d-flex flex-column">
                <span class="fw-bold text-gray-900 fs-5">
                    {{ strtoupper(auth()->user()->Fullname) }}
                </span>
                <span class="text-muted fs-6">
                    {{ auth()->user()->roles->first()->name ?? 'No Role Assigned' }}
                </span>
                <span class="text-muted fs-8">
                    {{ auth()->user()->position->PS_Name ?? 'Position' }}
                </span>
            </div>
        </div>

        <div class="separator my-3"></div>

        {{-- Quick Access Links --}}
        <div class="menu-item px-0">
            <a href="{{ route('changepasswordpage') }}" class="menu-link px-3 py-2 d-flex align-items-center hover-bg-light">
                <i class="bi bi-gear me-3 fs-5 text-warning"></i>
                <span class="fw-semibold">Change Password</span>
            </a>
        </div>

        <div class="separator my-3"></div>

        {{-- Logout --}}
        <div class="menu-item px-0">
            <form method="POST" action="{{ route('Logout') }}">
                @csrf
                <button type="submit" class="btn btn-danger btn-sm w-100 d-flex align-items-center justify-content-center">
                    <i class="bi bi-box-arrow-right me-2"></i> Sign Out
                </button>
            </form>
        </div>
    </div>
</div>
