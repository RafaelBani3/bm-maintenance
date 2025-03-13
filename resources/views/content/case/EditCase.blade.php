@extends('layouts.Master')

@section('title', 'BM-Maintenance')
@section('subtitle', 'BM Maintenance - Edit Case')

@section('content')
    @include('layouts.partial.breadcrumbs')

    <div class="card mt-5">
        <div class="card">
            <div class="card-header bg-danger text-white">
                <h3 class="mt-2">Edit Case</h3>
            </div>
            <div class="card-body">
                <form action="{{ route('cases.update') }}" method="POST" id="caseForm" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="case_no" value="{{ $case->Case_No }}">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Cases Name <span class="text-danger">*</span></label>
                            <input type="text" name="cases" id="cases" class="form-control" value="{{ $case->Case_Name }}" required>
                            <div class="invalid-feedback" id="error-cases"></div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Date <span class="text-danger">*</span></label>
                            <input type="date" name="date" id="date" class="form-control" value="{{ $case->Case_Date }}" required>
                            <div class="invalid-feedback" id="error-date"></div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Created By </label>
                            <input type="text" class="form-control" value="{{ auth()->user()->Fullname }}" readonly>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Departement</label>
                            <input type="text" class="form-control" value="" readonly>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Category <span class="text-danger">*</span></label>
                            <select name="category" class="form-select" required id="category">
                                <option value="">Choose Category</option>
                                @foreach ($categories as $cat)
                                    <option value="{{ $cat->Cat_No }}" {{ $case->Cat_No == $cat->Cat_No ? 'selected' : '' }}>
                                        {{ $cat->Cat_Name }}
                                    </option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback" id="error-category"></div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Sub Category <span class="text-danger">*</span></label>
                            <select name="sub_category" class="form-select" required id="sub_category">
                                <option value="">Choose Sub Category</option>
                                @foreach ($subCategories as $subCat)
                                    <option value="{{ $subCat->Scat_No }}" {{ $case->Scat_No == $subCat->Scat_No ? 'selected' : '' }}>
                                        {{ $subCat->Scat_Name }}
                                    </option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback" id="error-sub_category"></div>
                        </div>

                        <div class="col-12 mb-3">
                            <label class="form-label">Chronology <span class="text-danger">*</span></label>
                            <textarea name="chronology" class="form-control" id="chronology" rows="2" required>{{ $case->Case_Chronology }}</textarea>
                            <div class="invalid-feedback" id="error-chronology"></div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Outcome <span class="text-danger">*</span></label>
                            <textarea name="impact" class="form-control" id='impact' rows="2" required>{{ $case->Case_Outcome }}</textarea>
                            <div class="invalid-feedback" id="error-impact"></div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Suggest <span class="text-danger">*</span></label>
                            <textarea name="suggestion" class="form-control" id="suggest" rows="2" required>{{ $case->Case_Suggest }}</textarea>
                            <div class="invalid-feedback" id="error-suggest"></div>
                        </div>

                        <div class="col-12 mb-3">
                            <label class="form-label">Action <span class="text-danger">*</span></label>
                            <textarea name="action" class="form-control" rows="2" required>{{ $case->Case_Action }}</textarea>
                        </div>  

                        <div class="col-8 mb-3">
                            <label class="form-label">Current Photos</label>
                            <div id="existing-photos" class="mt-2 d-grid" style="grid-template-columns: repeat(4, 1fr); gap: 10px; justify-content: center;">
                                @if(count($caseImages) > 0)
                                    @foreach($caseImages as $index => $image)
                                        <div class="position-relative m-2" id="image-container-{{ $image->IMG_No }}">
                                            <img src="{{ asset('storage/case_photos/' . str_replace(['/', '\\'], '-', $case->Case_No) . '/' . $image->IMG_Filename) }}" 
                                                class="img-thumbnail" 
                                                style="width: 100%; max-width: 300px; height: 320px; object-fit: cover; cursor: pointer;"
                                                data-img-id="{{ $image->IMG_No }}">
                                            <input type="file" class="form-control mt-2" name="new_images[{{ $image->IMG_No }}]" accept="image/*">
                                        </div>
                                    @endforeach
                                @else
                                    <div class="alert alert-info">No photos uploaded yet.</div>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-end mt-3">
                        <button type="submit" class="btn btn-primary">Update Case</button>
                    </div>            
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="existingImageModal" tabindex="-1" aria-labelledby="existingImageModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="existingImageModalLabel">Image Preview</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <img id="existing-modal-image" src="" class="img-fluid" alt="Preview">
                </div>
                <div class="modal-footer">
                    <input type="hidden" id="current-image-id" value="">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    @include('content.case.partial.EditCase-script')

@endsection