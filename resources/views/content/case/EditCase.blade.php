
@extends('layouts.Master')

@section('title', 'BM-Maintenance')
@section('subtitle', 'Edit Case')

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
                        {{-- {{ route('cases.update') }} --}}
                        
                        <form action="" method="POST" id="caseForm" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="case_no" value="{{ $case->Case_No }}">

                            <div class="row">

                                <div class="fv-row col-md-6 mb-5">
                                    <label for="cases" class="required form-label">Case Name</label>
                                    <input type="text" name="cases" id="cases" class="form-control form-control-solid" value="{{ $case->Case_Name }}"/>
                                </div>
        
                                <div class="fv-row col-md-6 mb-5">
                                    <label for="date" class="form-label">Date</label>
                                    <input class="form-control form-control-solid" placeholder="Pick date & time" name="date" id="date" value="{{ $case->Case_Date }}"/>
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
                                    <select name="category" class="form-select"  id="category">
                                        <option value="">Choose Category</option>
                                        @foreach ($categories as $cat)
                                            <option value="{{ $cat->Cat_No }}" {{ $case->Cat_No == $cat->Cat_No ? 'selected' : '' }}>
                                                {{ $cat->Cat_Name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
        
                                <div class="fv-row col-md-6 mb-5">
                                    <label class="form-label">Sub Category <span class="text-danger">*</span></label>
                                    <select name="sub_category" class="form-select"  id="sub_category">
                                        <option value="">Choose Sub Category</option>
                                        @foreach ($subCategories as $subCat)
                                            <option value="{{ $subCat->Scat_No }}" {{ $case->Scat_No == $subCat->Scat_No ? 'selected' : '' }}>
                                                {{ $subCat->Scat_Name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
        
                                <div class="fv-row col-12 mb-5">
                                    <label class="form-label">Chronology <span class="text-danger">*</span></label>
                                    <textarea name="chronology" class="form-control" id="chronology" rows="2" >{{ $case->Case_Chronology }}</textarea>
                                </div>
        
                                <div class="fv-row col-md-6 mb-5">
                                    <label class="form-label">Outcome <span class="text-danger">*</span></label>
                                    <textarea name="impact" class="form-control" id='impact' rows="2" >{{ $case->Case_Outcome }}</textarea>
                                </div>
        
                                <div class="fv-row col-md-6 mb-5">
                                    <label class="form-label">Suggest <span class="text-danger">*</span></label>
                                    <textarea name="suggestion" class="form-control" id="suggest" rows="2" >{{ $case->Case_Suggest }}</textarea>
                                    <div class="invalid-feedback" id="error-suggest"></div>
                                </div>
        
                                <div class="fv-row col-12 mb-5">
                                    <label class="form-label">Action <span class="text-danger">*</span></label>
                                    <textarea name="action" class="form-control" rows="2" >{{ $case->Case_Action }}</textarea>
                                </div>  

                                <div class="fv-row mb-5 col-8">
                                    <label class="form-label">Current Photos</label>
                                    <div id="existing-photos" class="mt-2 d-grid" style="grid-template-columns: repeat(4, 1fr); gap: 10px; justify-content: center;">
                                        @if(count($caseImages) > 0)
                                            @foreach($caseImages as $index => $image)
                                                <div class="position-relative m-2" id="image-container-{{ $image->IMG_No }}">
                                                    <img src="{{ asset('storage/case_photos/' . str_replace(['/', '\\'], '-', $case->Case_No) . '/' . $image->IMG_Filename) }}" 
                                                        class="img-thumbnail" 
                                                        style="width: 100%; max-width: 300px; height: 320px; object-fit: cover; cursor: pointer;"
                                                        data-img-id="{{ $image->IMG_No }}">
                                                    {{-- <input type="file" class="form-control mt-2" name="new_images[{{ $image->IMG_No }}]" accept="image/*"> --}}
                                                    <button type="button" class="btn btn-danger btn-sm mt-2 delete-photo" data-img-id="{{ $image->IMG_No }}">Hapus Foto</button>
                                                </div>
                                            @endforeach
                                        @else
                                            <div class="alert alert-info">No photos uploaded yet.</div>
                                        @endif
                                    </div>
                                </div>

                                <div class="fv-row mb-5 mt-5">
                                    <label class="form-label">Upload Image <span class="text-danger">*</span></label>
                                    <div class="dropzone" id="case-dropzone">
                                        <div class="dz-message needsclick">
                                            <i class="ki-duotone ki-file-up text-primary fs-3x">
                                                <span class="path1"></span>
                                                <span class="path2"></span>
                                            </i>                                            
                                            <div class="ms-4">
                                                <h3 class="fs-5 fw-bold text-gray-900 mb-1">Drop files here or click to upload.</h3>
                                                <span class="fs-7 fw-semibold text-gray-500">Upload up to 5 files (Max 2MB each)</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <div class="d-flex justify-content-end mt-3">
                                {{-- <button type="submit" class="btn btn-primary">Update Case</button> --}}
                                {{-- <button id="kt_docs_formvalidation_text_submit" type="submit" class="btn btn-primary">
                                    <span class="indicator-label">
                                      Update Case
                                    </span>
                                    <span class="indicator-progress">
                                        Please wait... <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                                    </span>
                                </button> --}}
                                <button id="kt_docs_formvalidation_text_submit" type="submit" class="btn btn-primary">
                                    Update Case
                                </button>
                            </div>            
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Page Loader --}}
    {{-- <div id="page_loader" class="page-loader flex-column bg-dark bg-opacity-25" style="display: none; position: fixed; top: 100; left: 0; width: 100%; height: 100%; z-index: 9999; align-items: center; justify-content: center;">
        <span class="spinner-border text-primary" role="status"></span>
        <span class="text-gray-800 fs-6 fw-semibold mt-5">Loading...</span>
    </div> --}}

    <div id="page_loader" class="page-loader flex-column bg-dark bg-opacity-25" style="
        display: none; 
        position: fixed; 
        top: 0; 
        left: 0; 
        width: 100%; 
        height: 100%; 
        background: rgba(0, 0, 0, 0.5); 
        z-index: 9999; 
        flex-direction: column; 
        align-items: center; 
        justify-content: center;">
        
        <span class="spinner-border text-light" role="status" style="width: 3rem; height: 3rem;"></span>
        <span style="color: white; font-size: 1.5rem; font-weight: bold; margin-top: 15px;">Loading...</span>
    </div>

    <!-- Page Loader Element -->
    <div id="page-loader" class="d-none position-fixed top-0 start-0 w-100 h-100 bg-white bg-opacity-75 z-index-9999 d-flex align-items-center justify-content-center">
        <div class="spinner-border text-primary" role="status"></div>
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

    {{-- Preview Image Modal --}}
    <div class="modal fade" id="imagePreviewModal" tabindex="-1" aria-labelledby="imagePreviewModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="imagePreviewModalLabel">Image Preview</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <img id="previewImage" src="" class="img-fluid" alt="Preview Image">
                </div>
            </div>
        </div>
    </div>

    @include('content.case.partial.EditJs')

@endsection

