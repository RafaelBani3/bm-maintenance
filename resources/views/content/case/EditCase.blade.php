
@extends('layouts.Master')

@section('title', 'BM-Maintenance')
@section('subtitle', 'Case - Edit Case')

@section('content')
    
    <div class="app-main flex-column flex-row-fluid" id="kt_app_main">
        <!--begin::Content wrapper-->
        <div class="d-flex flex-column flex-column-fluid py-3 py-lg-6">
            <!--begin::Content-->
            <div id="kt_app_content" class="app-content flex-column-fluid">
                <!--begin::Content container-->
                <div id="kt_app_content_container" class="app-container container-xxl">
                    <!--begin::Timeline-->
                    <div class="card">
                        <!--begin::Card head-->
                        <div class="card-header card-header-stretch">
                            <!--begin::Title-->
                            <div class="card-title d-flex align-items-center">
                                <h3 class="fw-bold m-0 text-gray-800">@yield('title') - @yield('subtitle')</h3>
                            </div>
                            <!--end::Title-->
                        </div>
                        <!--end::Card head-->

                        <!--begin::Card body-->
                        <div class="card-body">
                            <!--begin::Tab Content-->
                            <div class="tab-content">
                                <!--begin::Tab panel-->
                                <div id="kt_activity_today" class="card-body p-0 tab-pane fade show active" role="tabpanel" aria-labelledby="kt_activity_today_tab">
                                    
                                    <div id="kt_account_settings_profile_details" class="collapse show">

                                        <!--begin::Alert-->
                                        <div class="alert alert-dismissible bg-light-warning border-dashed border-warning d-flex flex-column flex-sm-row p-5 mb-10" >
                                            <!--begin::Icon-->
                                            <i class="ki-duotone ki-notepad-edit fs-2hx text-gray-700 me-4 mb-5 mb-sm-0">
                                                <span class="path1"></span>
                                                <span class="path2"></span>
                                            </i>  
                                            <!--end::Icon-->

                                            <!--begin::Wrapper-->
                                            <div class="d-flex flex-column pe-0 pe-sm-10">
                                                <!--begin::Title-->
                                                <h5 class="mb-1 text-gray-900">Review Your Case Data Before Proceeding</h5>
                                                <!--end::Title-->

                                                <!--begin::Content-->
                                                <span class="text-gray-600">Please double-check the saved Case data. Make sure all information is accurate before moving on to the next process.</span>
                                                <!--end::Content-->
                                            </div>
                                            <!--end::Wrapper-->

                                            <!--begin::Close-->
                                            <button type="button" class="position-absolute position-sm-relative m-2 m-sm-0 top-0 end-0 btn btn-icon ms-sm-auto" data-bs-dismiss="alert">
                                                <i class="ki-duotone ki-cross fs-1 text-success"><span class="path1"></span><span class="path2"></span></i>
                                            </button>
                                            <!--end::Close-->
                                        </div>
                                        <!--end::Alert-->

                                        <!--begin::Form-->
                                        <form action="" method="POST" id="caseForm" enctype="multipart/form-data" class="form">
                                            @csrf
                                            <input type="hidden" name="case_no" value="{{ $case->Case_No }}">
                                            <!--begin::Card body-->
                                            <div class="card-body p-2">
                                        
                                                <!--begin::Input Cases-->
                                                <div class="row mb-10">
                                                    <!--begin::Label-->
                                                    <label for="cases" class="col-lg-4 col-form-label required fw-semibold fs-6">Case Name</label>
                                                    <!--end::Label-->
                                                    
                                                    <div class="col-lg-8">
                                                        <div class="col-lg-20 fv-row">
                                                            <input type="text" name="cases" id="cases" class="form-control form-control-lg form-control-solid mb-3 mb-lg-0" placeholder="Input Case Name" value="{{ $case->Case_Name }}"/>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!--end::Input Cases-->

                                                <!--begin::Input Date-->
                                                <div class="row mb-10">
                                                    <!--begin::Label-->
                                                    <label for="date" class="col-lg-4 col-form-label required fw-semibold fs-6">Date</label>
                                                    <!--end::Label-->
                                                    <div class="col-lg-8 fv-row">
                                                        <input class="form-control form-control-lg form-control-solid" placeholder="Pick date & time" name="date" id="date" value="{{ $case->Case_Date }}" />
                                                    </div>
                                                </div>
                                                <!--end::Input Date-->

                                                <!--begin::Input Created By-->
                                                <div class="row mb-10">
                                                    <!--begin::Label-->
                                                    <label for="date" class="col-lg-4 col-form-label required fw-semibold fs-6">Created By</label>
                                                    <!--end::Label-->
                                                    <div class="col-lg-8 fv-row">
                                                        <input type="text" name="phone" class="form-control form-control-lg form-control-solid" value="{{ auth()->user()->Fullname }}" readonly />
                                                    </div>
                                                </div>
                                                <!--end::Input Created By-->
                                                        
                                                <!--begin::Input Position-->
                                                <div class="row mb-10">
                                                    <!--begin::Label-->
                                                    <label class="col-lg-4 col-form-label required fw-semibold fs-6">Position</label>
                                                    <!--end::Label-->
                                                    <div class="col-lg-8 fv-row">
                                                        <input type="text" class="form-control form-control-lg form-control-solid" value="{{ auth()->user()->position->PS_Name }}" readonly />
                                                    </div>
                                                </div>
                                                <!--end::Input Position-->

                                                <!--begin::Input Category -->
                                                <div class="row mb-10">
                                                    <!--begin::Label-->
                                                    <label class="col-lg-4 col-form-label required fw-semibold fs-6">Category</label>
                                                    <!--end::Label-->
                                                    <div class="col-lg-8 fv-row">
                                                        <select class="form-select form-select-solid" name="category" data-control="select2" data-hide-search="true" id="category" data-placeholder="Select Category">
                                                            <option value="">Choose Category</option>
                                                            {{-- @foreach ($listCategory as $cat)
                                                                <option value="{{ $cat->Cat_No }}" class="text-dark">{{ $cat->Cat_Name }}</option>
                                                            @endforeach --}}
                                                            @foreach ($categories as $cat)
                                                                <option value="{{ $cat->Cat_No }}" {{ $case->Cat_No == $cat->Cat_No ? 'selected' : '' }}>
                                                                    {{ $cat->Cat_Name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <!--end::Input Category-->

                                                <!--begin::Input SubCategory -->
                                                <div class="row mb-10">
                                                    <!--begin::Label-->
                                                    <label class="col-lg-4 col-form-label required fw-semibold fs-6">Sub-Category</label>
                                                    <!--end::Label-->
                                                    <div class="col-lg-8 fv-row">
                                                        <select name="sub_category" id="sub_category" class="form-select form-select-solid">
                                                            <option value="">You Should Choose Category First</option>
                                                            @foreach ($subCategories as $subCat)
                                                                <option value="{{ $subCat->Scat_No }}" {{ $case->Scat_No == $subCat->Scat_No ? 'selected' : '' }}>
                                                                    {{ $subCat->Scat_Name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <!--end::Input SubCategory-->
                                        
                                                <!--begin::Input Chronology-->
                                                <div class="row mb-10">
                                                    <!--begin::Label-->
                                                    <label class="col-lg-4 col-form-label required fw-semibold fs-6">Chronology</label>
                                                    <!--end::Label-->
                                                    <div class="col-lg-8 fv-row">
                                                        <textarea class="form-control form-control-solid" rows="3" name="chronology" id="chronology" placeholder="Input Case Chronology">{{ $case->Case_Chronology }}</textarea>
                                                    </div>
                                                </div>
                                                <!--end::Input Chronology-->

                                                <!--begin::Input Outcome-->
                                                <div class="row mb-10">
                                                    <!--begin::Label-->
                                                    <label class="col-lg-4 col-form-label required fw-semibold fs-6">Outcome</label>
                                                    <!--end::Label-->
                                                    <div class="col-lg-8 fv-row">
                                                        <textarea class="form-control form-control-solid" rows="3" name="impact" id="impact" placeholder="Input Case Impact">{{ $case->Case_Outcome }}</textarea>
                                                    </div>
                                                </div>
                                                <!--end::Input Outcome-->

                                                <!--begin::Input Suggest-->
                                                <div class="row mb-10">
                                                    <!--begin::Label-->
                                                    <label class="col-lg-4 col-form-label required fw-semibold fs-6">Suggestion</label>
                                                    <!--end::Label-->
                                                    <div class="col-lg-8 fv-row">
                                                        <textarea class="form-control form-control-solid" rows="3" name="suggestion" id="suggestion" placeholder="Input Case suggestion">{{ $case->Case_Suggest }}</textarea>
                                                    </div>
                                                </div>
                                                <!--end::Input suggestion-->

                                                <!--begin::Input action-->
                                                <div class="row mb-10">
                                                    <!--begin::Label-->
                                                    <label class="col-lg-4 col-form-label required fw-semibold fs-6">Action</label>
                                                    <!--end::Label-->
                                                    <div class="col-lg-8 fv-row">
                                                        <textarea class="form-control form-control-solid" rows="3" name="action" id="action" placeholder="Input Case action">{{ $case->Case_Action }}</textarea>
                                                    </div>
                                                </div>
                                                <!--end::Input action-->

                                                <!--begin::Input Existing Image Dropzone-->
                                                <div class="row mb-5">
                                                    <!--begin::Label-->
                                                    <label class="col-lg-4 col-form-label fw-semibold fs-6">
                                                        <span class="required">Existing Image</span>
                                                        <span class="ms-1" data-bs-toggle="tooltip" title="This is the currently uploaded image. You can keep or replace it.">
                                                            <i class="ki-duotone ki-information-5 text-gray-500 fs-6">
                                                                <span class="path1"></span>
                                                                <span class="path2"></span>
                                                                <span class="path3"></span>
                                                            </i>
                                                        </span>
                                                    </label>
                                                    <!--end::Label-->
                                                    <div id="existing-photos" class="d-flex flex-row flex-wrap gap-4">
                                                        @foreach($caseImages as $index => $image)
                                                            <div class="d-flex flex-column align-items-center" id="image-container-{{ $image->IMG_No }}">
                                                                <!-- Gambar + Overlay -->
                                                                <a class="d-block overlay position-relative rounded shadow-sm" data-fslightbox="lightbox-case-images" 
                                                                    href="{{ asset('storage/case_photos/' . str_replace(['/', '\\'], '-', $case->Case_No) . '/' . $image->IMG_Filename) }}">
                                                                    <div class="overlay-wrapper card-rounded bgi-no-repeat bgi-position-center bgi-size-cover"
                                                                        style="background-image:url('{{ asset('storage/case_photos/' . str_replace(['/', '\\'], '-', $case->Case_No) . '/' . $image->IMG_Filename) }}'); width: 100px; height: 120px; border-radius: 0.65rem;">
                                                                    </div>
                                                                    <div class="overlay-layer card-rounded bg-dark bg-opacity-50 shadow d-flex align-items-center justify-content-center position-absolute top-0 start-0 w-100 h-100 rounded"
                                                                        style="transition: all 0.3s ease;">
                                                                        <i class="bi bi-eye-fill text-white fs-2x"></i>
                                                                    </div>
                                                                </a>
                                                                <button type="button" class="btn btn-icon btn-sm btn-danger mt-2 delete-photo" data-img-id="{{ $image->IMG_No }}" title="Hapus Foto">
                                                                    <i class="ki-duotone ki-trash">
                                                                        <span class="path1"></span>
                                                                        <span class="path2"></span>
                                                                        <span class="path3"></span>
                                                                        <span class="path4"></span>
                                                                        <span class="path5"></span>
                                                                    </i>
                                                                </button>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                                <!--end::Input Existing Image Dropzone-->

                                                <!--begin::Input Image Dropzone-->
                                                <div class="row mb-5">
                                                    <!--begin::Label-->
                                                    <label class="col-lg-4 col-form-label required fw-semibold fs-6">Upload Image</label>
                                                    <!--end::Label-->
                                                    <div class="fv-row mt-3">
                                                        <div class="dropzone" id="case-dropzone" name="photos[]">
                                                            <div class="dz-message needsclick">
                                                                <i class="ki-duotone ki-file-up text-primary fs-3x">
                                                                    <span class="path1"></span>
                                                                    <span class="path2"></span>
                                                                </i>
                                                                <div class="ms-4">
                                                                    <h3 class="fs-5 fw-bold text-gray-900 mb-1">Drop files here or click to upload.</h3>
                                                                    <span class="fs-7 fw-semibold text-gray-500">Upload up to 5 files</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!--end::Input Image Dropzone-->
                                            </div>
                                            <!--end::Card body-->

                                            <!--begin::Actions-->
                                            <div class="card-footer d-flex justify-content-end py-6 px-9">
                                                <button id="kt_docs_formvalidation_text_submit" type="submit" class="btn btn-primary">
                                                    <span class="indicator-label">
                                                    Submit Case
                                                    </span>
                                                    <span class="indicator-progress">
                                                        Please wait... <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                                                    </span>
                                                </button>
                                            </div>
                                            <!--end::Actions-->   
                                        </form>
                                        <!--end::Form-->
                                    </div>
                                    <!--end::Content-->
                                </div>
                                <!--end::Basic info-->
                            </div>
                            <!--end::Tab Content-->
                        </div>
                        <!--end::Card body-->
                    </div>
                    <!--end::Timeline-->
                </div>
                <!--end::Content container-->
            </div>
            <!--end::Content-->
        </div>
        <!--end::Content wrapper-->
    </div>

    {{-- Page Loader --}}
    <div id="page_loader" class="page-loader flex-column bg-dark bg-opacity-25" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; z-index: 9999; align-items: center; justify-content: center;">
        <span class="spinner-border text-primary" role="status"></span>
        <span class="text-white-800 fs-6 fw-semibold mt-5 text-white">Loading...</span>
    </div>

    <script>
        const BASE_URL = "{{ url('/') }}";
    </script>

    @include('content.case.partial.EditJs')
@endsection

