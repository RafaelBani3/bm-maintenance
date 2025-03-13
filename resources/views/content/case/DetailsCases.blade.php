@extends('layouts.Master')

@section('title', 'Detail Approval Cases ')
@section('subtitle', 'Details Approval Case')

@section('content')
    @include('layouts.partial.breadcrumbs')

    <div class="card mt-5">
        <div class="card">
            <div class="card-header bg-primary text-white" style="height: 60px">
                <h4 class="mb-0 mt-3">Case Details - {{ $case->Case_No }}</h4>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <strong>Case Name:</strong> {{ $case->Case_Name }}
                    </div>
                    <div class="col-md-6">
                        <strong>Created By:</strong> {{ optional($case->user)->Fullname ?? 'Unknown' }}
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <strong>Category:</strong> {{ $case->category->Cat_Name ?? '-' }}
                    </div>
                    <div class="col-md-6">
                        <strong>Sub Category:</strong> {{ $case->subCategory->Scat_Name ?? '-' }}
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <strong>Case Date:</strong> {{ \Carbon\Carbon::parse($case->Case_Date)->format('d M Y') }}
                    </div>
                    <div class="col-md-6">
                        <strong>Status:</strong> 
                        <span class="badge bg-{{ $case->Case_Status == 'OPEN' ? 'warning' : ($case->Case_Status == 'CLOSE' ? 'success' : 'primary') }}">
                            {{ $case->Case_Status }}
                        </span>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-12">
                        <strong>Chronology:</strong>
                        <p>{{ $case->Case_Chronology }}</p>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <strong>Outcome:</strong>
                        <p>{{ $case->Case_Outcome }}</p>
                    </div>
                    <div class="col-md-6">
                        <strong>Suggested Action:</strong>
                        <p>{{ $case->Case_Suggest }}</p>
                    </div>
                </div>

                <h4 class="mt-4">Gambar Terkait</h4>
                <div class="row">
                    @forelse ($images as $image)
                        <div class="col-md-3">
                            <div class="card">
                                <img src="{{ asset('storage/case_photos/' . str_replace(['/', '\\'], '-', $case->Case_No) . '/' . $image->IMG_Filename) }}" 
    
                                class="img-thumbnail" 
                                style="width: 100%; max-width: 300px; height: 320px; object-fit: cover; cursor: pointer;"
                                data-img-id="{{ $image->IMG_No }}">                            
                                <div class="card-body text-center">
                                    <p class="text-muted">{{ $image->IMG_Realname }}</p>
                                </div>
                            </div>

                        </div>
                    @empty
                        <p class="text-center">Tidak ada gambar tersedia.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    
@endsection
