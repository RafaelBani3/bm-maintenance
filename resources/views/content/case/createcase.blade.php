@extends('layouts.Master')

@section('title', 'BM-Maintenance')
@section('subtitle', 'Create Case')

@section('content')

{{-- <!-- Tambahkan ini di dalam <head> jika Dropzone belum ada -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/dropzone.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/dropzone.min.js"></script> --}}
    
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

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Cases Name <span class="text-danger">*</span></label>
                                    <input type="text" name="cases" id="cases" class="form-control" required>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Date <span class="text-danger">*</span></label>
                                    <input type="date" name="date" id="date" class="form-control" required value="{{ now()->toDateString() }}">
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Created By </label>
                                    <input type="text" class="form-control" value="{{ auth()->user()->Fullname }}" readonly>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Position</label>
                                    <input type="text" class="form-control" value="{{ auth()->user()->position->PS_Name }}" readonly>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Category <span class="text-danger">*</span></label>
                                    <select name="category" class="form-select text-dark" required id="category">
                                        <option value="">Choose Category</option>
                                        @foreach ($listCategory as $cat)
                                            <option value="{{ $cat->Cat_No }}" class="text-dark">{{ $cat->Cat_Name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Sub Category <span class="text-danger">*</span></label>
                                    <select name="sub_category" class="form-select text-dark" required id="sub_category" disabled>
                                        <option value="" class="text-dark">You Should Choose Category First</option>
                                    </select>
                                </div>

                                <div class="col-12 mb-3">
                                    <label class="form-label">Chronology <span class="text-danger">*</span></label>
                                    <textarea name="chronology" class="form-control" id="chronology" rows="2" required></textarea>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Outcome <span class="text-danger">*</span></label>
                                    <textarea name="impact" class="form-control" id="impact" rows="2" required></textarea>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Suggest <span class="text-danger">*</span></label>
                                    <textarea name="suggestion" class="form-control" id="suggest" rows="2" required></textarea>
                                </div>

                                <div class="col-12 mb-3">
                                    <label class="form-label">Action <span class="text-danger">*</span></label>
                                    <textarea name="action" class="form-control" rows="2" required></textarea>
                                </div>  

                                {{-- <div class="col-12 mb-3">
                                    <label class="form-label">Foto (Maksimal 5) <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <input type="file" name="photos[]" class="form-control" multiple accept="image/png, image/jpg, image/jpeg" id="photos" onchange="previewImages()">
                                    </div>
                                    <div id="error-photos" class="invalid-feedback"></div>
                                    <div id="photo-preview" class="mt-2 d-grid" style="grid-template-columns: repeat(4, 1fr); gap: 5px; justify-content: center;"></div>
                                </div> --}}

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
                                                <span class="fs-7 fw-semibold text-gray-500">Upload up to 10 files</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <div class="d-flex justify-content-end">
                                <button type="submit" class="btn btn-primary">Save</button>
                            </div>            
                        </form>
                    </div>
                </div>
            </div>
        </div>
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
    @include('content.case.partial.CreateJs')
@endsection

