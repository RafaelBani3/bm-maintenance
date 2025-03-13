@extends('layouts.Master')

@section('title', 'BM-Maintenance')
@section('subtitle', 'BM Maintenance - Create Case')

@section('content')
    @include('layouts.partial.breadcrumbs')

    <div class="card mt-5">
        <div class="card-header" style="background-color:crimson;">
            <h3 class="card-title mt-4 text-white">@yield('subtitle')</h3>
        </div>
        <div class="card-body">
            <form action="{{ route('SaveCase') }}" method="POST" id="caseForm" enctype="multipart/form-data">
                @csrf
                <div class="row">

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Cases Name <span class="text-danger">*</span></label>
                        <input type="text" name="cases" id="cases" class="form-control" required>
                        <div class="invalid-feedback" id="error-cases"></div>
                    </div>

                    {{-- <div class="col-md-6 mb-3">
                        <label class="form-label">No Cases</label>
                        <input type="text" name="no_cases" class="form-control" required>
                    </div> --}}

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Date <span class="text-danger">*</span></label>
                        <input type="date" name="date" id="date" class="form-control" required value="{{ now()->toDateString() }}">
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
                        <select name="category" class="form-select text-dark" required id="category">
                            <option value="">Choose Category</option>
                            @foreach ($listCategory as $cat)
                                <option value="{{ $cat->Cat_No }}" class="text-dark">{{ $cat->Cat_Name }}</option>
                            @endforeach
                        </select>
                        <div class="invalid-feedback" id="error-category"></div>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Sub Category <span class="text-danger">*</span></label>
                        <select name="sub_category" class="form-select text-dark" required id="sub_category" disabled>
                            <option value="" class="text-dark">You Should Choose Category First</option>
                        </select>
                        <div class="invalid-feedback" id="error-sub_category"></div>
                    </div>

                    <div class="col-12 mb-3">
                        <label class="form-label">Chronology <span class="text-danger">*</span></label>
                        <textarea name="chronology" class="form-control" id="chronology" rows="2" required></textarea>
                        <div class="invalid-feedback" id="error-chronology"></div>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Outcome <span class="text-danger">*</span></label>
                        <textarea name="impact" class="form-control" id='impact' rows="2" required></textarea>
                        <div class="invalid-feedback" id="error-impact"></div>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Suggest <span class="text-danger">*</span></label>
                        <textarea name="suggestion" class="form-control" id="suggest" rows="2" required></textarea>
                        <div class="invalid-feedback" id="error-suggest"></div>

                    </div>

                    <div class="col-12 mb-3">
                        <label class="form-label">Action <span class="text-danger">*</span></label>
                        <textarea name="action" class="form-control" rows="2" required></textarea>
                    </div>  

                    {{-- <div class="col-12 mb-3">
                        <label class="form-label">Foto (Maksimal 5) <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <input type="file" name="photos[]" class="form-control" multiple accept="image/*" id="photos" onchange="previewImages()">
                        </div>
                        <div id="photo-preview" class="mt-2 d-grid" style="grid-template-columns: repeat(4, 1fr); gap: 0px; justify-content: center;">
                        <div class="invalid-feedback" id="error-photos"></div>
                    </div> --}}

                    <div class="col-12 mb-3">
                        <label class="form-label">Foto (Maksimal 5) <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <input type="file" name="photos[]" class="form-control" multiple accept="image/png, image/jpg, image/jpeg" id="photos" onchange="previewImages()">
                        </div>
                        <div id="error-photos" class="invalid-feedback"></div>
                        <div id="photo-preview" class="mt-2 d-grid" style="grid-template-columns: repeat(4, 1fr); gap: 5px; justify-content: center;"></div>
                    </div>               
                </div>

                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>            
            </form>
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

    @include('content.case.partial.CreateCase-script')
    

@endsection
