@extends('layouts.Master')

@section('title', 'BM Maintenance')
@section('subtitle', 'Create Case')

@section('content')

    <style>
        .flatpickr-day.today-highlight {
            background-color: #007bff !important;
            color: white !important;
            border-radius: 50%;
        }

        .flatpickr-day.today {
            background: #0d6efd !important; /* Bootstrap Primary Blue */
            color: #fff !important;
            border-radius: 6px;
        }

    </style>

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
                                        <!--begin::Form-->
                                        <form action="" method="POST" id="caseForm" enctype="multipart/form-data" class="form">
                                            @csrf
                                            <!--begin::Card body-->
                                            <div class="card-body p-2">
                                         
                                                <!--begin::Input Cases-->
                                                <div class="row mb-10">
                                                    <!--begin::Label-->
                                                    <label for="cases" class="col-lg-4 col-form-label required fw-semibold fs-6">Case Name</label>
                                                    <!--end::Label-->
                                                    
                                                    <div class="col-lg-8">
                                                        <div class="col-lg-20 fv-row">
                                                            <input type="text" name="cases" id="cases" class="form-control form-control-lg form-control-solid mb-3 mb-lg-0" placeholder="Input Case Name" />
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
                                                        <input class="form-control form-control-lg form-control-solid" placeholder="Pick date & time" name="date" id="date"/>
                                                    </div>
                                                </div>
                                                <!--end::Input Date-->
                                    
                                                <!--begin::Input Created By-->
                                                <div class="row mb-10">
                                                    <!--begin::Label-->
                                                    <label for="date" class="col-lg-4 col-form-label required fw-semibold fs-6">Created By</label>
                                                    <!--end::Label-->
                                                    <div class="col-lg-8 fv-row">
                                                        <input type="text" name="phone" class="form-control form-control-lg form-control-solid" 
                                                        value="{{ auth()->user()->Fullname }}" readonly />
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
                                                            @foreach ($listCategory as $cat)
                                                                <option value="{{ $cat->Cat_No }}" class="text-dark">{{ $cat->Cat_Name }}</option>
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
                                                        <select class="form-select form-select-solid" name="sub_category" id="sub_category" disabled>
                                                            <option value="">You Should Choose Category First</option>
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
                                                        <textarea class="form-control form-control-solid" rows="3" name="chronology" id="chronology" placeholder="Input Case Chronology"></textarea>
                                                    </div>
                                                </div>
                                                <!--end::Input Chronology-->

                                                <!--begin::Input Outcome-->
                                                <div class="row mb-10">
                                                    <!--begin::Label-->
                                                    <label class="col-lg-4 col-form-label required fw-semibold fs-6">Outcome</label>
                                                    <!--end::Label-->
                                                    <div class="col-lg-8 fv-row">
                                                        <textarea class="form-control form-control-solid" rows="3" name="impact" id="impact" placeholder="Input Case Impact"></textarea>
                                                    </div>
                                                </div>
                                                <!--end::Input Outcome-->

                                                <!--begin::Input Suggest-->
                                                <div class="row mb-10">
                                                    <!--begin::Label-->
                                                    <label class="col-lg-4 col-form-label required fw-semibold fs-6">Suggestion</label>
                                                    <!--end::Label-->
                                                    <div class="col-lg-8 fv-row">
                                                        <textarea class="form-control form-control-solid" rows="3" name="suggestion" id="suggestion" placeholder="Input Case suggestion"></textarea>
                                                    </div>
                                                </div>
                                                <!--end::Input suggestion-->

                                                <!--begin::Input action-->
                                                <div class="row mb-10">
                                                    <!--begin::Label-->
                                                    <label class="col-lg-4 col-form-label required fw-semibold fs-6">Action</label>
                                                    <!--end::Label-->
                                                    <div class="col-lg-8 fv-row">
                                                        <textarea class="form-control form-control-solid" rows="3" name="action" id="action" placeholder="Input Case action"></textarea>
                                                    </div>
                                                </div>
                                                <!--end::Input action-->

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
                                                      Create Case
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

    <div id="page_loader" class="page-loader flex-column bg-dark bg-opacity-25" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; z-index: 9999; align-items: center; justify-content: center;">
        <span class="spinner-border text-primary" role="status"></span>
        <span class="text-white-800 fs-6 fw-semibold mt-5 text-white">Loading...</span>
    </div>

    <!-- Modal untuk Preview Gambar -->
    <div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="imageModalLabel">Preview Gambar</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <img id="modal-image" src="" class="img-fluid" alt="Preview">
                </div>
                <div class="modal-footer">
                    <input type="file" id="change-photo" class="d-none" accept="image/*" onchange="changeImage()">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!--begin::Page loading(append to body)-->
    <div class="page-loader flex-column bg-dark bg-opacity-25">
        <span class="spinner-border text-primary" role="status"></span>
        <span class="text-gray-800 fs-6 fw-semibold mt-5">Loading...</span>
    </div>
    <!--end::Page loading-->

    @include('content.case.partial.CreateJs')
    <script>
        const BASE_URL = "{{ url('/') }}";
    </script>
@endsection
