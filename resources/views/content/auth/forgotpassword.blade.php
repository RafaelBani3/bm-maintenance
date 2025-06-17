<!DOCTYPE html>

<html lang="en">
	
<head>
		<title>Login BM-Maintenance</title>
		<meta charset="utf-8" />	
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<link rel="shortcut icon" href="assets/media/logos/favicon.ico" />

		<!--begin::Fonts(mandatory for all pages)-->
		<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700" />
		<!--end::Fonts-->

		<!--begin::Global Stylesheets Bundle(mandatory for all pages)-->
		<link href="{{ asset('assets/plugins/global/plugins.bundle.css') }}" rel="stylesheet" type="text/css" />
		<link href="{{ asset('assets/css/style.bundle.css') }}" rel="stylesheet" type="text/css"/>

		<link href="{{ asset('assets/css/custom-style.css') }}" rel="stylesheet" type="text/css"/>		
		<!--end::Global Stylesheets Bundle-->
	</head>


	<!--begin::Body-->
	<body id="kt_body" class="app-blank bgi-size-cover bgi-attachment-fixed bgi-position-center">
		<script>var defaultThemeMode = "light"; var themeMode; if ( document.documentElement ) { if ( document.documentElement.hasAttribute("data-bs-theme-mode")) { themeMode = document.documentElement.getAttribute("data-bs-theme-mode"); } else { if ( localStorage.getItem("data-bs-theme") !== null ) { themeMode = localStorage.getItem("data-bs-theme"); } else { themeMode = defaultThemeMode; } } if (themeMode === "system") { themeMode = window.matchMedia("(prefers-color-scheme: dark)").matches ? "dark" : "light"; } document.documentElement.setAttribute("data-bs-theme", themeMode); }</script>
		<!--end::Theme mode setup on page load-->

		<!--begin::Root-->
		<div class="d-flex flex-column flex-root" id="kt_app_root">
			
            <!--begin::Page bg image-->
			<style>body { background-image: url('assets/media/auth/bg10.jpeg'); } [data-bs-theme="dark"] body { background-image: url('assets/media/auth/bg10-dark.jpeg'); }</style>
			<!--end::Page bg image-->
			
            <!--begin::Authentication - Sign-in -->
			<div class="d-flex flex-column flex-lg-row flex-column-fluid">
				
                <!--begin::Aside-->
				<div class="d-flex flex-lg-row-fluid">
					<!--begin::Content-->
					<div class="d-flex flex-column flex-center pb-0 pb-lg-10 p-10 w-100">
						<!--begin::Image-->
						<img class="theme-light-show mx-auto mw-200 w-250px w-lg-300px mb-10 mb-lg-20" src="assets/media/auth/agency.png" alt="" />
						<img class="theme-dark-show mx-auto mw-200 w-250px w-lg-300px mb-10 mb-lg-20" src="assets/media/auth/agency-dark.png" alt="" />
						<!--end::Image-->
						
						<!--begin::Title-->
						<h1 class="text-gray-800 fs-2qx fw-bold text-center mb-7">BM-Maintenance System</h1>
						<!--end::Title-->

						<!--begin::Text-->
						<div class="text-gray-600 fs-base text-center fw-semibold">
							A centralized system for managing building maintenance, cases, work orders,<br/>
							and material requests efficiently across all your properties.<br/>
							Ensure faster response, better coordination, and reliable operations.
						</div>
						<!--end::Text-->

					</div>
					<!--end::Content-->
				</div>
				<!--begin::Aside-->

				<!--begin::Body-->
				<div class="d-flex flex-column-fluid flex-lg-row-auto justify-content-center justify-content-lg-end p-12">
					<!--begin::Wrapper-->
					<div class="bg-body d-flex flex-column flex-center rounded-4 w-md-600px p-10">
						<!--begin::Content-->
						<div class="d-flex flex-center flex-column align-items-stretch h-lg-100 w-md-400px">
							<!--begin::Wrapper-->
							<div class="d-flex flex-center flex-column flex-column-fluid pb-15 pb-lg-20">
								<!--begin::Form-->

                                <!--begin::Heading-->
								<div class="text-center mb-11">
									<img src="assets/media/logos/kpn-corp-logo.svg" alt="KPN Logo" class="mb-5" style="height: 70px;">
									<h1 class="text-gray-900 fw-bold fs-1 mb-3">Welcome to BM-Maintenance</h1>
									<div class="text-muted fw-semibold fs-6">KPN CORPORATION</div>
								</div>
								<!--begin::Heading-->

								<!--Start::Form-->
                                 <form method="POST" action="{{ route('password.reset') }}">
                                    @csrf

                                    @if(session('error'))
                                        <div class="alert alert-danger">{{ session('error') }}</div>
                                    @endif
                                    @if(session('success'))
                                        <div class="alert alert-success">{{ session('success') }}</div>
                                    @endif

                                    <div class="mb-3">
                                        <label for="Username" class="form-label">Username</label>
                                        <input type="text" name="Username" class="form-control" required value="{{ old('Username') }}">
                                        @error('Username') <div class="text-danger">{{ $message }}</div> @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="new_password" class="form-label">New Password</label>
                                        <input type="password" name="new_password" class="form-control" required>
                                        @error('new_password') <div class="text-danger">{{ $message }}</div> @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="new_password_confirmation" class="form-label">Confirm New Password</label>
                                        <input type="password" name="new_password_confirmation" class="form-control" required>
                                    </div>

                                    <button type="submit" class="btn btn-primary">Update Password</button>
                                </form>
                               
								<!--end::Form-->

							</div>
							<!--end::Wrapper-->

                            <!--begin::CopyRight-->
							<div class="text-center mt-10 text-gray-600 fs-7">
								&copy; 2025 KPN Corporation. All Rights Reserved.
							</div>
							<!--end::CopyRight-->
						</div>
						<!--end::Content-->
					</div>
					<!--end::Wrapper-->
				</div>
				<!--end::Body-->
			</div>
			<!--end::Authentication - Sign-in-->
		</div>
		<!--end::Root-->

		<!--begin::Javascript-->
		<script>var hostUrl = "assets/";</script>
        
		<!--begin::Global Javascript Bundle(mandatory for all pages)-->
		<script src="assets/plugins/global/plugins.bundle.js"></script>
		<script src="assets/js/scripts.bundle.js"></script>
		<!--end::Global Javascript Bundle-->

		<!--end::Javascript-->
	</body>
	<!--end::Body-->


    {{-- Tambahkan SweetAlert2 CDN jika belum ada --}}

    @if(session('password_reset_success'))
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Password Updated',
            text: 'Your password has been successfully updated.',
            confirmButtonText: 'OK'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = "{{ route('login') }}";
            }
        });
    </script>
    @endif


</html>