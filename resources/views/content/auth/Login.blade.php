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
<<<<<<< HEAD
									<!--begin::Title-->
									<h1 class="text-gray-900 fw-bolder mb-3">Login BM-Maintenance</h1>  
									<!--end::Title-->
										
                                    <!--begin::Subtitle-->
									<div class="text-gray-500 fw-semibold fs-6">KPN CORPORATION</div>
									<!--end::Subtitle=-->
=======
									<img src="assets/media/logos/kpn-corp-logo.svg" alt="KPN Logo" class="mb-5" style="height: 70px;">
									<h1 class="text-gray-900 fw-bold fs-1 mb-3">Welcome to BM-Maintenance</h1>
									<div class="text-muted fw-semibold fs-6">KPN CORPORATION</div>
>>>>>>> ff25b43 (Update)
								</div>
								<!--begin::Heading-->

								<!--Start::Form-->
								<form class="form w-100" novalidate="novalidate" method="POST" action="{{ route('Login.post') }}">
									@csrf
									@if ($errors->any())
										<div class="alert alert-danger">
											<ul class="mb-0">
												@foreach ($errors->all() as $error)
													<li>{{ $error }}</li>
												@endforeach
											</ul>
										</div>
									@endif

									<!-- Username -->
									<div class="fv-row mb-8">
										<label class="form-label fw-bold fs-6 mb-2">Username</label>
										<input type="text" placeholder="Input Username" name="Username" value="{{ old('Username') }}" autocomplete="off" class="form-control bg-transparent @error('Username') is-invalid @enderror" />
										@error('Username')
											<div class="fv-error text-danger mt-2">{{ $message }}</div>
										@enderror
									</div>

									<!-- Password -->
									<div class="fv-row mb-3">
										<label class="form-label fw-bold fs-6 mb-2">Password</label>
										<input type="password" placeholder="Input Password" name="Password" autocomplete="off" class="form-control bg-transparent @error('Password') is-invalid @enderror" />
										@error('Password')
											<div class="fv-error text-danger mt-2">{{ $message }}</div>
										@enderror
									</div>

									<!--begin::Wrapper-->
									<div class="d-flex flex-stack flex-wrap gap-3 fs-base fw-semibold mb-8">
										<div></div>
										<!--begin::Link-->
										<a href="#" class="link-primary">Forgot Password ?</a>
										<!--end::Link-->
									</div>
									<!--end::Wrapper-->

									<!--begin::Submit button-->
									<div class="d-grid mb-10">
										<button type="submit" class="btn btn-primary">
											<!--begin::Indicator label-->
											<span class="indicator-label">Login</span>
											<!--end::Indicator label-->

											<!--begin::Indicator progress-->
											<span class="indicator-progress">Please wait... 
											<span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
											<!--end::Indicator progress-->
										</button>
									</div>
									<!--end::Submit button-->

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


	<script>
		document.querySelector('form').addEventListener('submit', function(e) {
			let isValid = true;

			document.querySelectorAll('.fv-error').forEach(el => el.remove());

			this.querySelectorAll('input[name="Username"], input[name="Password"]').forEach(function(input) {
				if (input.value.trim() === '') {
					isValid = false;

					const error = document.createElement('div');
					error.classList.add('fv-error', 'text-danger', 'mt-2');
					error.innerText = input.name + ' is required';
					input.parentNode.appendChild(error);
				}
			});

			if (!isValid) {
				e.preventDefault();
			}
		});
	</script>

	<script>
		document.querySelector("form").addEventListener("submit", function () {
			const btn = this.querySelector("button[type=submit]");
			btn.querySelector(".indicator-label").style.display = "none";
			btn.querySelector(".indicator-progress").style.display = "inline-block";
			btn.setAttribute("disabled", "true");
		});
	</script>

</html>