
<!--begin::Sidebar-->
<div id="kt_app_sidebar" class="app-sidebar flex-column" data-kt-drawer="true" 
        data-kt-drawer-name="app-sidebar" data-kt-drawer-activate="{default: true, lg: false}" 
        data-kt-drawer-overlay="true" data-kt-drawer-width="225px" data-kt-drawer-direction="start" 
        data-kt-drawer-toggle="#kt_app_sidebar_mobile_toggle">
    
    <!--begin::Logo-->
    <div class="app-sidebar-logo px-6" id="kt_app_sidebar_logo">
        <!--begin::Logo image-->
        <a href="{{ route('Dashboard') }}">
            <img alt="Logo" src="{{ asset('assets/media/logos/kpn-corp.png') }}" class="h-25px app-sidebar-logo-default" />
            <img alt="Logo" src="{{ asset('assets/media/logos/kpn-corp-logo.svg') }}" class="h-20px app-sidebar-logo-minimize" />            
        </a>

        <div id="kt_app_sidebar_toggle" class="app-sidebar-toggle btn btn-icon btn-shadow btn-sm btn-color-muted btn-active-color-primary h-30px w-30px position-absolute top-50 start-100 translate-middle rotate" data-kt-toggle="true" data-kt-toggle-state="active" data-kt-toggle-target="body" data-kt-toggle-name="app-sidebar-minimize">
            <i class="ki-duotone ki-black-left-line fs-3 rotate-180">
                <span class="path1"></span>
                <span class="path2"></span>
            </i>
        </div>
        <!--end::Sidebar toggle-->
    </div>
    <!--end::Logo-->

    <!--begin::sidebar menu-->
    <div class="app-sidebar-menu overflow-hidden flex-column-fluid">
        <!--begin::Menu wrapper-->
        <div id="kt_app_sidebar_menu_wrapper" class="app-sidebar-wrapper">

            <!--begin::Scroll wrapper-->
            <div id="kt_app_sidebar_menu_scroll" class="scroll-y my-5 mx-3" 
                data-kt-scroll="true" data-kt-scroll-activate="true" data-kt-scroll-height="auto" 
                data-kt-scroll-dependencies="#kt_app_sidebar_logo, #kt_app_sidebar_footer" 
                data-kt-scroll-wrappers="#kt_app_sidebar_menu" data-kt-scroll-offset="5px" 
                data-kt-scroll-save-state="true">

                <!--begin::Menu-->
                <div class="menu menu-column menu-rounded menu-sub-indention fw-semibold fs-6" 
                    id="#kt_app_sidebar_menu" data-kt-menu="true" data-kt-menu-expand="false">
                    
                    <!--begin:Menu Dashboard-->
                    <div data-kt-menu-trigger="click" class="menu-item {{ request()->routeIs('Dashboard') ? 'show' : '' }}">
                        <!--begin:Menu Dashboard-->
                        <a class="{{ request()->routeIs('Dashboard') ? 'active' : '' }}" href="{{ route('Dashboard') }}">
                            <span class="menu-link">
                                <span class="menu-icon">
                                    <i class="ki-duotone ki-element-11 fs-2">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                        <span class="path3"></span>
                                        <span class="path4"></span>
                                    </i>
                                </span>
                                <span class="menu-title">Dashboards</span>
                            </span>
                        </a>
                        <!--end:Menu link-->
                    </div>
                    <!--end:Menu item-->

                    <!--begin:Menu item-->
                    <div class="menu-item pt-5">
                        <!--begin:Menu content-->
                        <div class="menu-content">
                            <span class="menu-heading fw-bold text-uppercase fs-7">Pages</span>
                        </div>
                        <!--end:Menu content-->
                    </div>
                    <!--end:Menu item-->

                    {{-- Page Case --}}
                    @if(auth()->user()->hasAnyPermission(['view cr', 'view cr_ap']))
                        <div data-kt-menu-trigger="click" class="menu-item menu-accordion {{ request()->routeIs('CreateCase', 'ViewCase', 'ApprovalCase') ? 'show' : '' }}">
                            <span class="menu-link">
                                <span class="menu-icon">
                                    <i class="ki-duotone ki-note-2 fs-2">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                        <span class="path3"></span>
                                        <span class="path4"></span>
                                    </i>
                                </span>
                                <span class="menu-title">Case</span>
                                <span class="menu-arrow"></span>
                            </span>

                            <div class="menu-sub menu-sub-accordion">
                                @if(auth()->user()->hasAnyPermission(['view cr']))
                                    <div class="menu-item">
                                        <a class="menu-link {{ request()->routeIs('CreateCase') ? 'active' : '' }}" href="{{ route('CreateCase') }}">
                                            <span class="menu-bullet">
                                                <span class="bullet bullet-dot"></span>
                                            </span>
                                            <span class="menu-title">Create Case</span>
                                        </a>
                                    </div>
                                @endif

                                    <div class="menu-item">
                                        <a class="menu-link {{ request()->routeIs('ViewCase') ? 'active' : '' }}" href="{{ route('ViewCase') }}">
                                            <span class="menu-bullet">
                                                <span class="bullet bullet-dot"></span>
                                            </span>
                                            <span class="menu-title">List Case</span>
                                        </a>
                                    </div>
                                
                                @if(auth()->user()->hasAnyPermission(['view cr_ap']))
                                    <div class="menu-item">
                                        <a class="menu-link {{ request()->routeIs('ApprovalCase') ? 'active' : '' }}" href="{{ route('ApprovalCase') }}">
                                            <span class="menu-bullet">
                                                <span class="bullet bullet-dot"></span>
                                            </span>
                                            <span class="menu-title">Approval Case</span>
                                        </a>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endif

                    {{-- Page WO --}}
                    @if(auth()->user()->hasAnyPermission(['view wo']))
                        <!--begin:Menu item-->
                        <div data-kt-menu-trigger="click" class="menu-item menu-accordion {{ request()->routeIs('CreateWO', 'ListWO') ? 'show' : '' }}">
                            <span class="menu-link">
                                <span class="menu-icon">
                                    <i class="ki-duotone ki-briefcase fs-2">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                    </i>
                                </span>
                                <span class="menu-title">Work Order</span>
                                <span class="menu-arrow"></span>
                            </span>
                            
                            <div class="menu-sub menu-sub-accordion">
                                <div class="menu-item">
                                    <a class="menu-link {{ request()->routeIs('CreateWO') ? 'active' : '' }}" href="{{ route('CreateWO') }}">
                                        <span class="menu-bullet">
                                            <span class="bullet bullet-dot"></span>
                                        </span>
                                        <span class="menu-title">Create Work Order</span>
                                    </a>
                                </div>
                            </div>

                            <div class="menu-sub menu-sub-accordion">
                                <div class="menu-item">
                                    <a class="menu-link {{ request()->routeIs('ListWO') ? 'active' : '' }}" href="{{ route('ListWO') }}">
                                        <span class="menu-bullet">
                                            <span class="bullet bullet-dot"></span>
                                        </span>
                                        <span class="menu-title">List Work Order</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endif

                    {{-- Page MR --}}
                    @if(auth()->user()->hasAnyPermission(['view mr', 'view mr_ap']))
                        <!--begin:Menu item-->
                        <div data-kt-menu-trigger="click" class="menu-item menu-accordion {{ request()->routeIs('CreateMR', 'ListMR', 'ApprovalListMR' ) ? 'show' : '' }}">
                            <span class="menu-link">
                                <span class="menu-icon">
                                    <i class="ki-duotone ki-parcel-tracking fs-2">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                    <span class="path3"></span>
                                    </i>
                                </span>
                                <span class="menu-title">Material Request</span>
                                <span class="menu-arrow"></span>
                            </span>
                        
                            @if(auth()->user()->hasAnyPermission(['view mr']))
                                <div class="menu-sub menu-sub-accordion">
                                    <div class="menu-item">
                                        <a class="menu-link {{ request()->routeIs('CreateMR') ? 'active' : '' }}" href="{{ route('CreateMR') }}">
                                            <span class="menu-bullet">
                                                <span class="bullet bullet-dot"></span>
                                            </span>
                                            <span class="menu-title">Create Material Request</span>
                                        </a>
                                    </div>
                                </div>
                            @endif

                                <div class="menu-sub menu-sub-accordion">
                                    <div class="menu-item">
                                        <a class="menu-link {{ request()->routeIs('ListMR') ? 'active' : '' }}" href="{{ route('ListMR') }}">
                                            <span class="menu-bullet">
                                                <span class="bullet bullet-dot"></span>
                                            </span>
                                            <span class="menu-title">List Material Request</span>
                                        </a>
                                    </div>
                                </div>

                            @if(auth()->user()->hasAnyPermission(['view mr_ap']))
                                <div class="menu-sub menu-sub-accordion">
                                    <div class="menu-item">
                                        <a class="menu-link {{ request()->routeIs('ApprovalListMR') ? 'active' : '' }}" href="{{ route('ApprovalListMR') }}">
                                            <span class="menu-bullet">
                                                <span class="bullet bullet-dot"></span>
                                            </span>
                                            <span class="menu-title">Approval Material Request</span>
                                        </a>
                                    </div>
                                </div>
                            @endif
                        </div>
                    @endif

                    {{-- WOC --}}
                    @if(auth()->user()->hasAnyPermission(['view cr', 'view wo','view cr_ap']))
                        <div data-kt-menu-trigger="click" class="menu-item menu-accordion {{ request()->routeIs('CreateWOC', 'ListWOCPage', 'ApprovalListWOC') ? 'show' : '' }}">
                            <span class="menu-link">
                                <span class="menu-icon">
                                    <i class="ki-duotone ki-folder-added fs-2">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                    </i>
                                </span>
                                <span class="menu-title">Work Order Complition</span>
                                <span class="menu-arrow"></span>
                            </span>

                            <div class="menu-sub menu-sub-accordion">
                                @if(auth()->user()->hasAnyPermission(['view cr']))
                                    <div class="menu-item">
                                        <a class="menu-link {{ request()->routeIs('CreateWOC') ? 'active' : '' }}" href="{{ route('CreateWOC') }}">
                                            <span class="menu-bullet">
                                                <span class="bullet bullet-dot"></span>
                                            </span>
                                            <span class="menu-title">Create Work Order Complition</span>
                                        </a>
                                    </div>
                                @endif    
                                    <div class="menu-item">
                                        <a class="menu-link {{ request()->routeIs('ListWOCPage') ? 'active' : '' }}" href="{{ route('ListWOCPage') }}">
                                            <span class="menu-bullet">
                                                <span class="bullet bullet-dot"></span>
                                            </span>
                                            <span class="menu-title">List Work Order Complition</span>
                                        </a>
                                    </div>
                                

                                @if(auth()->user()->hasAnyPermission(['view cr_ap']))
                                    <div class="menu-item">
                                        <a class="menu-link {{ request()->routeIs('ApprovalListWOC') ? 'active' : '' }}" href="{{ route('ApprovalListWOC') }}">
                                            <span class="menu-bullet">
                                                <span class="bullet bullet-dot"></span>
                                            </span>
                                            <span class="menu-title">Approval WOC</span>
                                        </a>
                                    </div>
                                @endif
                            
                            </div>
                        </div>
                    @endif

                    {{-- ADD DATA --}}
                    @if(auth()->user()->hasAnyRole(['SuperAdminCreator','SuperAdminApprover']))
                        <div data-kt-menu-trigger="click" class="menu-item menu-accordion {{ request()->routeIs('CreateNewUser' ) ? 'show' : '' }}">
                            <span class="menu-link">
                                <span class="menu-icon">
                                    <i class="ki-duotone ki-user-edit fs-2">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                    <span class="path3"></span>
                                    </i>                                
                                </span>
                                <span class="menu-title">Admin Panel</span>
                                <span class="menu-arrow"></span>
                            </span>
                        
                            <div class="menu-sub menu-sub-accordion">
                                <div class="menu-item">
                                    <a class="menu-link {{ request()->routeIs('CreateNewUser') ? 'active' : '' }}" href="{{ route('CreateNewUser') }}">
                                        <span class="menu-bullet">
                                            <span class="bullet bullet-dot"></span>
                                        </span>
                                        <span class="menu-title">User List</span>
                                    </a>
                                </div>
                            </div>

                            <div class="menu-sub menu-sub-accordion">
                                <div class="menu-item">
                                    <a class="menu-link {{ request()->routeIs('CreateNewMatrix') ? 'active' : '' }}" href="{{ route('CreateNewMatrix') }}">
                                        <span class="menu-bullet">
                                            <span class="bullet bullet-dot"></span>
                                        </span>
                                        <span class="menu-title">Matrix List</span>
                                    </a>
                                </div>
                            </div>

                            <div class="menu-sub menu-sub-accordion">
                                <div class="menu-item">
                                    <a class="menu-link {{ request()->routeIs('PositionPage') ? 'active' : '' }}" href="{{ route('PositionPage') }}">
                                        <span class="menu-bullet">
                                            <span class="bullet bullet-dot"></span>
                                        </span>
                                        <span class="menu-title">Position List</span>
                                    </a>
                                </div>
                            </div>

                            <div class="menu-sub menu-sub-accordion">
                                <div class="menu-item">
                                    <a class="menu-link {{ request()->routeIs('CategoryPage') ? 'active' : '' }}" href="{{ route('CategoryPage') }}">
                                        <span class="menu-bullet">
                                            <span class="bullet bullet-dot"></span>
                                        </span> 
                                        <span class="menu-title">Category & Subcategory</span>
                                    </a>
                                </div>
                            </div>

                            <div class="menu-sub menu-sub-accordion">
                                <div class="menu-item">
                                    <a class="menu-link {{ request()->routeIs('TechnicianPage') ? 'active' : '' }}" href="{{ route('TechnicianPage') }}">
                                        <span class="menu-bullet">
                                            <span class="bullet bullet-dot"></span>
                                        </span> 
                                        <span class="menu-title">Technician List</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endif

                    <div data-kt-menu-trigger="click" class="menu-item {{ request()->routeIs('TrackingPage') ? 'show' : '' }}">
                        <!--begin:Menu Dashboard-->
                        <a class="{{ request()->routeIs('TrackingPage') ? 'active' : '' }}" href="{{ route('TrackingPage') }}">
                            <span class="menu-link">
                                <span class="menu-icon">
                                    <i class="ki-duotone ki-element-11 fs-2">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                        <span class="path3"></span>
                                        <span class="path4"></span>
                                    </i>
                                </span>
                                <span class="menu-title">Tracking List</span>
                            </span>
                        </a>
                        <!--end:Menu link-->
                    </div>
                </div>
                <!--end::Menu-->
               
            </div>
            <!--end::Scroll wrapper-->
        </div>
        <!--end::Menu wrapper-->
    </div>
    <!--end::sidebar menu-->
</div>


