 {{--User Profile  --}}
 <div class="navbar-profile dropdown" style="color: #343a40; padding: 0.5rem; border-radius: 0.5rem;">
    {{-- Photo Profile --}}
    <a class="nav-link d-flex align-items-center" href="#" data-bs-toggle="dropdown" id="profileDropdown" style="text-decoration: none; cursor: pointer;">
        <img src="../assets/images/faces/face28.jpg" alt="profile" class="me-2" style="width: 40px; height: 40px; border-radius: 50%; object-fit: cover;" />
    </a>
    {{-- Dropdown --}}
    <div class="dropdown-menu dropdown-menu-end" style="min-width: 200px; box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15); border-radius: 0.5rem; overflow: hidden;">
      <div class="dropdown-item d-flex align-items-center">
          <div class="d-flex flex-column">
            <div class="fw-bold fs-6 mb-1">
                {{ strtoupper(auth()->user()->Fullname) }}
            </div>
        
            <div>
                <a href="#" class="fw-semibold text-muted text-hover-primary fs-7">
                    {{ auth()->user()->roles->first()->name }}
                </a>
            </div>
          </div>
      </div>  
        <div class="dropdown-divider"></div>
        {{-- Profile Settings --}}
        <a class="dropdown-item d-flex align-items-center" href="#">
          <i class="ti-settings text-primary me-2"></i> Settings
        </a>
        {{-- Log-out --}}
        <a class="dropdown-item d-flex align-items-center" href="javascript:void(0)" onclick="document.getElementById('logout-form').submit();">
            <i class="ti-power-off text-danger me-2"></i> Logout
        </a>

          <form method="POST" action="{{ route('Logout') }}" id="logout-form" class="d-none">
            @csrf
          </form>
        </li>
    </div>
</div>