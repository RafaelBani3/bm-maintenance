{{-- Header - Partial --}}
<nav class="navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
    <div class="navbar-brand-wrapper d-flex align-items-center justify-content-start text-center" >
        {{-- Logo --}}
        <a class="navbar-brand brand-logo " href="../index.html">
            <img src="../assets/images/logos/kpn-corp.png" alt="logo" />
        </a>
        <a class="navbar-brand brand-logo-mini" href="../index.html">
            <img src="../assets/images/logos/kpn-corp-logo.svg" class="me-5" alt="logo" />
        </a>

        <div class="navbar-menu-wrapper d-flex align-items-center ms-3" style="background-color: #131313; border-bottom: #fff 1px solid;">
            <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
              <span class="ti-arrow-left" style="color: #676a6d"></span>
            </button>  
        </div>
    </div>

    <div class="navbar-menu-wrapper d-flex align-items-center justify-content-end">
        {{-- User Menu --}}
        @include('layouts.partial.user-menu')
        <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
          <span class="icon-menu"></span>
        </button>
    </div>
</nav>
