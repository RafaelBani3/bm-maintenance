@extends('layouts.Master')

@section('title', 'BM-Maintenance')
@section('subtitle', 'Create Case')

@section('content')

    <div id="kt_app_content" class="app-content flex-column-fluid">
        <div id="kt_app_content_container" class="app-container container-fluid">
            <div class="card mb-5 mb-xl-10">
                <div class="card-header border-0">
                    <div class="card-title m-0"><h3 class="fw-bold m-0">@yield('title') - @yield('subtitle')</h3>
                    </div>
                </div>
                
                <div id="kt_account_settings_profile_details" class="collapse show">
                    <div class="card-body border-top p-5">
                        <form action="" method="POST" id="caseForm" enctype="multipart/form-data">
                            @csrf
                            <div class="row">

                                <div class="fv-row mb-5 col-md-6">
                                    <label for="cases" class="required form-label">Case Name</label>
                                    <input type="text" name="cases" id="cases" class="form-control form-control-solid" placeholder="Input Case Name"/>
                                </div>

                                <div class="fv-row col-md-6 mb-5">
                                    <label for="" class="form-label">Date</label>
                                    <input class="form-control form-control-solid" placeholder="Pick date & time" name="date" id="date"/>
                                </div>
                  
                                <div class="fv-row col-md-6 mb-5">
                                    <label class="form-label">Created By </label>
                                    <input type="text" class="form-control form-control-solid" value="{{ auth()->user()->Fullname }}" readonly/>
                                </div>
                                        
                                <div class="fv-row col-md-6 mb-5">
                                    <label class="form-label">Position</label>
                                    <input type="text" class="form-control form-control-solid" value="{{ auth()->user()->position->PS_Name }}" readonly/>
                                </div>

                                <div class="fv-row col-md-6 mb-5">
                                    <label class="form-label">Category <span class="text-danger">*</span></label>
                                    <select name="category" class="form-select" id="category">
                                        <option value="">Choose Category</option>
                                        @foreach ($listCategory as $cat)
                                            <option value="{{ $cat->Cat_No }}" class="text-dark">{{ $cat->Cat_Name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="fv-row col-md-6 mb-5">
                                    <label class="form-label">Sub Category <span class="text-danger">*</span></label>
                                    <select name="sub_category" class="form-select" id="sub_category" disabled>
                                        <option value="">You Should Choose Category First</option>                                     
                                    </select>
                                </div>


                                <div class="fv-row col-12 mb-5">
                                    <label class="form-label">Chronology <span class="text-danger">*</span></label>
                                    <textarea name="chronology" class="form-control" id="chronology" rows="2" placeholder="Input Chronology" ></textarea>
                                </div>

                                <div class="fv-row col-md-6 mb-5">
                                    <label class="form-label">Outcome <span class="text-danger">*</span></label>
                                    <textarea name="impact" class="form-control" id="impact" rows="2" placeholder="Input Impact"></textarea>
                                </div>

                                <div class="fv-row col-md-6 mb-5">
                                    <label class="form-label">Suggest <span class="text-danger">*</span></label>
                                    <textarea name="suggestion" class="form-control" id="suggestion" rows="2" placeholder="Input Suggest" ></textarea>
                                </div>

                                <div class="fv-row col-12 mb-5">
                                    <label class="form-label">Action <span class="text-danger">*</span></label>
                                    <textarea name="action" class="form-control" id="action" rows="2" placeholder="Input Action" ></textarea>
                                </div>  

                                {{-- Dropzone --}}
                                <div class="fv-row mb-5 mt-5">
                                    <label class="form-label">Upload Image <span class="text-danger">*</span></label>
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

                            <div class="d-flex justify-content-end">
                                <button id="kt_docs_formvalidation_text_submit" type="submit" class="btn btn-primary">
                                    <span class="indicator-label">
                                      Save Case
                                    </span>
                                    <span class="indicator-progress">
                                        Please wait... <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                                    </span>
                                </button>
                            </div>            
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="page_loader" class="page-loader flex-column bg-dark bg-opacity-25" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; z-index: 9999; align-items: center; justify-content: center;">
        <span class="spinner-border text-primary" role="status"></span>
        <span class="text-gray-800 fs-6 fw-semibold mt-5">Loading...</span>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
        <div class="modal-dialog">
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
@endsection

