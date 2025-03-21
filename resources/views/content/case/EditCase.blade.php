
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
                        <form action="{{ route('cases.update') }}" method="POST" id="caseForm" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="case_no" value="{{ $case->Case_No }}">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Case Name <span class="text-danger">*</span></label>
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
                                    <label class="form-label">Position</label>
                                    <input type="text" class="form-control" value="{{ auth()->user()->position->PS_Name }}" readonly>
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
        </div>
    </div>

    @include('content.case.partial.EditJs')

@endsection