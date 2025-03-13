<!DOCTYPE html>

<html lang="en">
	
<head>
		<title>Login BM-Maintenance</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<link rel="shortcut icon" href="authassets/media/logos/favicon.ico" />

		<!--begin::Fonts(mandatory for all pages)-->
		<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700" />
		<!--end::Fonts-->

		<!--begin::Global Stylesheets Bundle(mandatory for all pages)-->
		<link href="{{ asset('authassets/plugins/global/plugins.bundle.css') }}" rel="stylesheet" type="text/css" />
		<link href="{{ asset('authassets/css/style.bundle.css') }}" rel="stylesheet" type="text/css"/>

		<link href="{{ asset('authassets/css/custom-style.css') }}" rel="stylesheet" type="text/css"/>		<!--end::Global Stylesheets Bundle-->

	</head>
	<!--begin::Body-->
	<body id="kt_body" class="app-blank bgi-size-cover bgi-attachment-fixed bgi-position-center">
		<!--begin::Theme mode setup on page load-->
		<script>var defaultThemeMode = "light"; var themeMode; if ( document.documentElement ) { if ( document.documentElement.hasAttribute("data-bs-theme-mode")) { themeMode = document.documentElement.getAttribute("data-bs-theme-mode"); } else { if ( localStorage.getItem("data-bs-theme") !== null ) { themeMode = localStorage.getItem("data-bs-theme"); } else { themeMode = defaultThemeMode; } } if (themeMode === "system") { themeMode = window.matchMedia("(prefers-color-scheme: dark)").matches ? "dark" : "light"; } document.documentElement.setAttribute("data-bs-theme", themeMode); }</script>
		<!--end::Theme mode setup on page load-->

		<!--begin::Root-->
		<div class="d-flex flex-column flex-root" id="kt_app_root">
			
            <!--begin::Page bg image-->
			<style>body { background-image: url('authassets/media/auth/bg10.jpeg'); } [data-bs-theme="dark"] body { background-image: url('authassets/media/auth/bg10-dark.jpeg'); }</style>
			<!--end::Page bg image-->
			
            <!--begin::Authentication - Sign-in -->
			<div class="d-flex flex-column flex-lg-row flex-column-fluid">
				
                <!--begin::Aside-->
				<div class="d-flex flex-lg-row-fluid">
					<!--begin::Content-->
					<div class="d-flex flex-column flex-center pb-0 pb-lg-10 p-10 w-100">
						<!--begin::Image-->
						<img class="theme-light-show mx-auto mw-100 w-150px w-lg-300px mb-10 mb-lg-20" src="authassets/media/auth/agency.png" alt="" />
						<img class="theme-dark-show mx-auto mw-100 w-150px w-lg-300px mb-10 mb-lg-20" src="authassets/media/auth/agency-dark.png" alt="" />
						<!--end::Image-->
						<!--begin::Title-->
						<h1 class="text-gray-800 fs-2qx fw-bold text-center mb-7">Fast, Efficient and Productive</h1>
						<!--end::Title-->
						<!--begin::Text-->
						<div class="text-gray-600 fs-base text-center fw-semibold">In this kind of post, 
						<a href="#" class="opacity-75-hover text-primary me-1">the blogger</a>introduces a person they’ve interviewed 
						<br />and provides some background information about 
						<a href="#" class="opacity-75-hover text-primary me-1">the interviewee</a>and their 
						<br />work following this is a transcript of the interview.</div>
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
									<!--begin::Title-->
									<h1 class="text-gray-900 fw-bolder mb-3">Login BM-Maintenance</h1>  
									<!--end::Title-->
										
                                    <!--begin::Subtitle-->
									<div class="text-gray-500 fw-semibold fs-6">KPN CORP</div>
									<!--end::Subtitle=-->
								</div>
								<!--begin::Heading-->

								<form class="form w-100" novalidate="novalidate" method="POST" action="{{ route('Login.post') }}">
									@csrf
									<!--begin::Input Username =-->
									<div class="fv-row mb-8">
                                        <label class="form-label fw-bold fs-6 mb-2">Username</label>
										<input type="text" placeholder="Input Username" name="Username" autocomplete="off" class="form-control bg-transparent" />
									</div>
									<!--end::Username Input=-->

                                    <!--begin::Password-->
									<div class="fv-row mb-3">
                                        <label class="form-label fw-bold fs-6 mb-2">Password</label>
										<input type="password" placeholder="Input Password" name="Password" autocomplete="off" class="form-control bg-transparent" />
									</div>
									<!--end::password Input=-->

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

							<!--begin::Footer-->
							<div class="d-flex flex-stack">

                                <!--begin::CopyRight-->
								<div class="d-flex fw-semibold text-primary fs-base gap-5">
                                    <span class="text-muted fw-semibold me-1">2025&copy;</span>
                                    <a href="#" class="text-gray-800 text-hover-primary">MIS KPN_Corp</a>
								</div>
								<!--end::CopyRight-->

								<!--begin::Languages-->
								<div class="me-10">
									<!--begin::Toggle-->
									<button class="btn btn-flex btn-link btn-color-gray-700 btn-active-color-primary rotate fs-base" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-start" data-kt-menu-offset="0px, 0px">
										<img data-kt-element="current-lang-flag" class="w-20px h-20px rounded me-3" src="authassets/media/flags/united-states.svg" alt="" />
										<span data-kt-element="current-lang-name" class="me-1">English</span>
										<i class="ki-duotone ki-down fs-5 text-muted rotate-180 m-0"></i>
									</button>
									<!--end::Toggle-->

									<!--begin::Menu-->
									<div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg-light-primary fw-semibold w-200px py-4 fs-7" data-kt-menu="true" id="kt_auth_lang_menu">
										<!--begin::Menu item-->
										<div class="menu-item px-3">
											<a href="#" class="menu-link d-flex px-5" data-kt-lang="English">
												<span class="symbol symbol-20px me-4">
													<img data-kt-element="lang-flag" class="rounded-1" src="authassets/media/flags/united-states.svg" alt="" />
												</span>
												<span data-kt-element="lang-name">English</span>
											</a>
										</div>
										<!--end::Menu item-->
										<!--begin::Menu item-->
										<div class="menu-item px-3">
											<a href="#" class="menu-link d-flex px-5" data-kt-lang="Spanish">
												<span class="symbol symbol-20px me-4">
													<img data-kt-element="lang-flag" class="rounded-1" src="authassets/media/flags/spain.svg" alt="" />
												</span>
												<span data-kt-element="lang-name">Spanish</span>
											</a>
										</div>
										<!--end::Menu item-->
										<!--begin::Menu item-->
										<div class="menu-item px-3">
											<a href="#" class="menu-link d-flex px-5" data-kt-lang="German">
												<span class="symbol symbol-20px me-4">
													<img data-kt-element="lang-flag" class="rounded-1" src="authassets/media/flags/germany.svg" alt="" />
												</span>
												<span data-kt-element="lang-name">German</span>
											</a>
										</div>
										<!--end::Menu item-->
										<!--begin::Menu item-->
										<div class="menu-item px-3">
											<a href="#" class="menu-link d-flex px-5" data-kt-lang="Japanese">
												<span class="symbol symbol-20px me-4">
													<img data-kt-element="lang-flag" class="rounded-1" src="authassets/media/flags/japan.svg" alt="" />
												</span>
												<span data-kt-element="lang-name">Japanese</span>
											</a>
										</div>
										<!--end::Menu item-->
										<!--begin::Menu item-->
										<div class="menu-item px-3">
											<a href="#" class="menu-link d-flex px-5" data-kt-lang="French">
												<span class="symbol symbol-20px me-4">
													<img data-kt-element="lang-flag" class="rounded-1" src="authassets/media/flags/france.svg" alt="" />
												</span>
												<span data-kt-element="lang-name">French</span>
											</a>
										</div>
										<!--end::Menu item-->
									</div>
									<!--end::Menu-->
								</div>
								<!--end::Languages-->
							
							</div>
							<!--end::Footer-->

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
		<script>var hostUrl = "authassets/";</script>
        
		<!--begin::Global Javascript Bundle(mandatory for all pages)-->
		<script src="authassets/plugins/global/plugins.bundle.js"></script>
		<script src="authassets/js/scripts.bundle.js"></script>
		<!--end::Global Javascript Bundle-->

		<!--end::Javascript-->
	</body>
	<!--end::Body-->
</html>