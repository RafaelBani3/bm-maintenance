<div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
    <div id="kt_app_toolbar_container" class="app-container container-fluid d-flex align-items-center">
        <!-- Tombol Back -->
        <a href="#" class="btn btn-icon btn-circle btn-primary me-3" onclick="window.history.go(-1); return false;">
            <i class="ki-duotone ki-arrow-left fs-1">
                <span class="path1"></span>
                <span class="path2"></span>
            </i>        
        </a>

        <!-- Title dan Subtitle -->
        <div>
            <h2 class="font-weight-bold mb-2">@yield('title')</h2>
            <h5 class="font-weight-normal mb-0" style="margin-left: 2px">@yield('subtitle')</h5>
        </div>
    </div>
</div>
