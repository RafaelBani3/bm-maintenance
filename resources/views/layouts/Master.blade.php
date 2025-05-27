<!DOCTYPE html>

<html lang="en">
	<!--begin::Head-->
	<head>
		<title>@yield('title')</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<meta name="csrf-token" content="{{ csrf_token() }}">
		<link rel="shortcut icon" href="assets/media/logos/favicon.ico" />
		<meta name="csrf-token" content="{{ csrf_token() }}">

		<!--begin::Fonts(mandatory for all pages)-->
		<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700"/>
		
		<link href="{{ asset('assets/css/style.bundle.css') }}" rel="stylesheet" type="text/css"/>
		<link href="{{ asset('assets/css/custom-style.css') }}" rel="stylesheet" type="text/css"/>
		
		<link href="{{ asset('assets/plugins/global/plugins.bundle.css') }}" rel="stylesheet" type="text/css"/>
		<script src="{{ asset('assets/plugins/global/plugins.bundle.js') }}"></script>
		<script src="{{ asset('assets/plugins/custom/fslightbox/fslightbox.bundle.js') }}"></script>
		<script src="{{ asset('assets/plugins/custom/formrepeater/formrepeater.bundle.js') }}"></script>
<<<<<<< HEAD
		<!-- Tambahkan ini kalau belum ada -->
		<script src="{{ asset('assets/plugins/custom/formrepeater/formrepeater.bundle.js') }}"></script>
		<script src="{{ asset('assets/plugins/custom/formrepeater/formrepeater.bundle.js') }}"></script> 

=======
		<script src="{{ asset('assets/plugins/custom/formrepeater/formrepeater.bundle.js') }}"></script>
		<script src="{{ asset('assets/plugins/custom/formrepeater/formrepeater.bundle.js') }}"></script> 
		<script src="//www.google.com/jsapi"></script>
		<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
>>>>>>> ff25b43 (Update)
	</head>
	<!--end::Head-->
	<!--begin::Body-->
	<body id="kt_app_body" data-kt-app-layout="dark-sidebar" data-kt-app-header-fixed="true" data-kt-app-sidebar-enabled="true" data-kt-app-sidebar-fixed="true" data-kt-app-sidebar-hoverable="true" data-kt-app-sidebar-push-header="true" data-kt-app-sidebar-push-toolbar="true" data-kt-app-sidebar-push-footer="true" data-kt-app-toolbar-enabled="true" class="app-default">
		<div class="d-flex flex-column flex-root app-root min-vh-100" id="kt_app_root">
			<div class="app-page flex-column flex-column-fluid d-flex flex-grow-1" id="kt_app_page">
<<<<<<< HEAD
				
=======
				{{-- Header --}}
>>>>>>> ff25b43 (Update)
				@include('layouts.partial.header')
		
				<div class="app-wrapper flex-column flex-row-fluid d-flex flex-grow-1" id="kt_app_wrapper">
					{{-- Sidebar --}}
					@include('layouts.partial.sidebar')
		
					<div class="app-main flex-column flex-row-fluid d-flex flex-column" id="kt_app_main">
						{{-- Breadcrumbs --}}
						<div class="d-flex">
							@include('layouts.partial.breadcrumbs')
						</div>
		
						<!-- Main Content -->
						<div class="flex-grow-1">
							@yield('content')
						</div>

						<!--begin::Page loading(append to body)-->
						<div class="page-loader flex-column bg-dark bg-opacity-25">
							<span class="spinner-border text-primary" role="status"></span>
							<span class="text-gray-800 fs-6 fw-semibold mt-5">Loading...</span>
						</div>
						<!--end::Page loading-->
		
						<!-- Footer -->
						<div class="mt-auto">
							@include('layouts.partial.footer')
						</div>
					</div>
				</div>
			</div>
		</div>		
	
		<!--begin::Javascript-->
		<script>var hostUrl = "{{ asset('assets/') }}";</script>

		<!--begin::Global Javascript Bundle(mandatory for all pages)-->
		<script src="{{ asset('assets/plugins/global/plugins.bundle.js') }}"></script>
		<script src="{{ asset('assets/js/scripts.bundle.js') }}"></script>
		<!--end::Global Javascript Bundle-->
     
        <link href="{{ asset('assets/plugins/global/plugins.bundle.css') }}" rel="stylesheet" type="text/css"/>
        <script src="{{ asset('assets/plugins/global/plugins.bundle.js') }}"></script>

		<!--begin::Vendors Javascript(used for this page only)-->
		<script src="{{ asset('assets/plugins/custom/fullcalendar/fullcalendar.bundle.js') }}"></script>
		<script src="https://cdn.amcharts.com/lib/5/index.js"></script>
		<script src="https://cdn.amcharts.com/lib/5/xy.js"></script>
		<script src="https://cdn.amcharts.com/lib/5/percent.js"></script>
		<script src="https://cdn.amcharts.com/lib/5/radar.js"></script>
		<script src="https://cdn.amcharts.com/lib/5/themes/Animated.js"></script>
		<script src="https://cdn.amcharts.com/lib/5/map.js"></script>
		<script src="https://cdn.amcharts.com/lib/5/geodata/worldLow.js"></script>
		<script src="https://cdn.amcharts.com/lib/5/geodata/continentsLow.js"></script>
		<script src="https://cdn.amcharts.com/lib/5/geodata/usaLow.js"></script>
		<script src="https://cdn.amcharts.com/lib/5/geodata/worldTimeZonesLow.js"></script>
		<script src="https://cdn.amcharts.com/lib/5/geodata/worldTimeZoneAreasLow.js"></script>
		<script src="{{ asset('assets/plugins/custom/datatables/datatables.bundle.js') }}"></script>
		<script src="//www.google.com/jsapi"></script>
		<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

		<!--end::Vendors Javascript-->

		<!--begin::Custom Javascript(used for this page only)-->
		<script src="{{ asset('assets/js/widgets.bundle.js') }}"></script>
		<script src="{{ asset('assets/js/custom/widgets.js') }}"></script>
		<script src="{{ asset('assets/js/custom/apps/chat/chat.js') }}"></script>
		<script src="{{ asset('assets/js/custom/utilities/modals/upgrade-plan.js') }}"></script>
		<script src="{{ asset('assets/js/custom/utilities/modals/create-app.js') }}"></script>
		<script src="{{ asset('assets/js/custom/utilities/modals/new-target.js') }}"></script>
		<script src="{{ asset('assets/js/custom/utilities/modals/user-search.js') }}"></script>
		<!--end::Custom Javascript-->
		<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

		<script>
			@if(session('error'))
				Swal.fire({
					icon: 'error',
					title: 'Oops...',
					text: '{{ session('error') }}',
					confirmButtonText: 'OK'
				});
			@endif

			@if(session('success'))
				Swal.fire({
					icon: 'success',
					title: 'Berhasil',
					text: '{{ session('success') }}',
					confirmButtonText: 'OK'
				});
			@endif
		</script>

		<!--end::Javascript-->	
	</body>
	<!--end::Body-->
</html>

