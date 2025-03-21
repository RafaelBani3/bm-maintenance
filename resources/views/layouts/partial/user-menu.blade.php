<div class="app-navbar-item ms-1 ms-md-4" id="kt_header_user_menu_toggle">
    <div class="cursor-pointer symbol symbol-35px"
         data-kt-menu-trigger="{default: 'click', lg: 'hover'}" data-kt-menu-attach="parent"
         data-kt-menu-placement="bottom-end">
        <img src="{{ asset('assets/media/avatars/profile.jpeg') }}" style="obeject-fit: contain" class="rounded-3" alt="user"/>
    </div>

    <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg menu-state-color fw-semibold py-4 fs-6 w-275px"
        data-kt-menu="true">
        <div class="menu-item px-3">
            <div class="menu-content d-flex align-items-center px-3">
                <div class="d-flex flex-column">
                    <div class="fw-bold d-flex align-items-center fs-5">
                        {{ strtoupper(auth()->user()->Fullname) }}
                    </div>
                    <a href="#" class="fw-semibold text-muted text-hover-primary fs-7">
                        {{ auth()->user()->roles->first()->name }}
                    </a>
                </div>
            </div>
        </div>

        <div class="separator my-2"></div>

        {{-- Logout --}}
        <div class="menu-item px-5">
            <form method="POST" action="{{ route('Logout') }}">
                @csrf
                <button type="submit" class="btn w-100 menu-link px-5">Sign Out</button>
            </form>
        </div>
    </div>
</div>
