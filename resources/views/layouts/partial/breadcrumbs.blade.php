
    <div id="kt_app_toolbar_container" class="app-container container-xxl d-flex flex-stack">
        <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
            <!-- Tombol Back -->
            <a href="#" class="btn btn-icon btn-circle btn-primary me-3" onclick="window.history.go(-1); return false;">
                <i class="ki-duotone ki-arrow-left fs-1">
                    <span class="path1"></span>
                    <span class="path2"></span>
                </i>        
            </a>
                
            <!--begin::Page title-->
            <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">

                <!--begin::Title-->
                <h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">@yield('title')</h1>
                <!--end::Title-->
                
                <!--begin::Breadcrumb-->
                <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                    <!--begin::Item-->
                    <li class="breadcrumb-item text-muted">
                        <a href="{{ route('Dashboard') }}" class="text-muted text-hover-primary">Dashboard</a>
                    </li>
                    <!--end::Item-->

                    <!--begin::Item-->
                    <li class="breadcrumb-item">
                        <span class="bullet bg-gray-500 w-5px h-2px"></span>
                    </li>
                    <!--end::Item-->

                    <!--begin::Item-->
                    <li class="breadcrumb-item text-muted">@yield('subtitle')</li>
                    <!--end::Item-->
                </ul>
                <!--end::Breadcrumb-->
            </div>
        </div>
    </div>