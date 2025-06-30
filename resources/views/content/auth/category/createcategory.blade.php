@extends('layouts.Master')

@section('title', 'BM Maintenance')
@section('subtitle', 'List Category')

@section('content')

    <div class="app-main flex-column flex-row-fluid" id="kt_app_main">
        <div class="d-flex flex-column flex-column-fluid py-3 py-lg-6">
            <div id="kt_app_content" class="app-content flex-column-fluid">
                <div id="kt_app_content_container" class="app-container container-xxl">
                    
                    {{-- Card Category --}}
                    <div class="card">
                        <div class="card-header card-header-stretch justify-content-between align-items-center">
                            <div class="card-title d-flex align-items-center">
                                <h3 class="fw-bold m-0 text-gray-800">@yield('title') - @yield('subtitle')</h3>
                            </div>
                            <div class="card-toolbar">
                                <button type="button" class="btn btn-sm btn-primary d-flex align-items-center" data-bs-toggle="modal" data-bs-target="#modalCreateCategory">
                                    <i class="bi bi-plus-circle fs-5 me-2"></i> Add New Category
                                </button>
                            </div>
                        </div>

                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="kt_datatable_horizontal_scroll" class="table table-striped table-row-bordered gy-5 gs-7">
                                    <thead>
                                        <tr class="fw-semibold fs-6 text-gray-800 text-nowrap">
                                            <th class="min-w-200px">Category No</th>
                                            <th class="min-w-200px">Category Name</th>
                                            <th class="min-w-300px">Description</th>
                                            <th class="min-w-150px">Created At</th>
                                            <th class="min-w-150px text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($category as $cats)
                                            <tr>
                                                <td>{{ $cats->Cat_No }}</td>
                                                <td>{{ $cats->Cat_Name}}</td>
                                                <td>{{ $cats->Cat_Desc}}</td>
                                                <td>{{ $cats->created_at}}</td>
                                                <td class="text-center">
                                                    <button class="btn btn-sm btn-light-primary me-1 btn-edit-category"
                                                            data-id="{{ $cats->Cat_No }}"
                                                            data-name="{{ $cats->Cat_Name }}"
                                                            data-desc="{{ $cats->Cat_Desc }}"
                                                            title="Edit"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#modalEditCategory">
                                                        <i class="bi bi-pencil-square"></i>
                                                    </button>


                                                    <button class="btn btn-sm btn-light-danger btn-delete-category"
                                                            data-id="{{ $cats->Cat_No }}"
                                                            data-name="{{ $cats->Cat_Name }}"
                                                            title="Delete">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="pt-5 pb-5"></div>

                    {{-- Card Table Subcategory --}}
                    <div class="card">
                        <div class="card-header card-header-stretch justify-content-between align-items-center">
                            <div class="card-title d-flex align-items-center">
                                <h3 class="fw-bold m-0 text-gray-800">@yield('title') - SubCategory</h3>
                            </div>
                            <div class="card-toolbar">
                                <button type="button" class="btn btn-sm btn-primary d-flex align-items-center" data-bs-toggle="modal" data-bs-target="#modalCreateSubCategory">
                                    <i class="bi bi-plus-circle fs-5 me-2"></i> Add New Sub-Category
                                </button>
                            </div>
                        </div>

                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="kt_datatable_horizontal_scroll_2" class="table table-striped table-row-bordered gy-5 gs-7">
                                    <thead>
                                        <tr class="fw-semibold fs-6 text-gray-800 text-nowrap">
                                            <th class="min-w-200px">Sub-Category No</th>
                                            <th class="min-w-200px">Sub-Category Name</th>
                                            <th class="min-w-300px">Description</th>
                                            <th class="min-w-150px">Created At</th>
                                            <th class="min-w-150px text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($subcategory as $scats)
                                            <tr>
                                                <td>{{ $scats->Scat_No }}</td>
                                                <td>{{ $scats->Scat_Name}}</td>
                                                <td>{{ $scats->Scat_Desc}}</td>
                                                <td>{{ $scats->created_at}}</td>
                                                <td class="text-center">
                                                    <button class="btn btn-sm btn-light-primary me-1" data-bs-toggle="tooltip" title="Edit"
                                                        onclick="editSubCategory('{{ $scats->Scat_No }}', '{{ $scats->Scat_Name }}', '{{ $scats->Scat_Desc }}', '{{ $scats->Cat_No }}')">
                                                        <i class="bi bi-pencil-square"></i>
                                                    </button>



                                                    {{-- <button class="btn btn-sm btn-light-danger" data-bs-toggle="tooltip" title="Delete" onclick="deletePosition('{{ route('DeleteSubCategory', $scats->Scat_No) }}')">
                                                        <i class="bi bi-trash"></i>
                                                    </button> --}}
                                                    <button class="btn btn-sm btn-light-danger btn-delete-subcategory"
                                                            data-id="{{ $scats->Scat_No }}"
                                                            data-name="{{ $scats->Scat_Name }}"
                                                            title="Delete">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </td>
                                            </tr>   
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Modal Create Category-->
                    <div class="modal fade" id="modalCreateCategory" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered mw-650px">
                            <form class="modal-content" method="POST" action="{{ route('SaveCategory') }}">
                                @csrf
                                <div class="modal-header">
                                    <h2>Add New Category</h2>
                                    <div class="btn btn-sm btn-icon btn-active-light-primary" data-bs-dismiss="modal">
                                        <i class="bi bi-x fs-2"></i>
                                    </div>
                                </div>
                                <div class="modal-body py-10 px-lg-17">
                                    <div class="mb-5">
                                        <label class="form-label">Category Name</label>
                                        <input type="text" class="form-control" name="Cat_Name" required />
                                    </div>
                                    <div class="mb-5">
                                        <label class="form-label">Description</label>
                                        <textarea class="form-control" name="Cat_Desc" required></textarea>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-primary">Save</button>
                                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <!-- End Modal Category-->

                    <!-- Modal Edit Category-->
                    <div class="modal fade" id="modalEditCategory" tabindex="-1" aria-labelledby="modalEditCategoryLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <form id="editCategoryForm" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Edit Category</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body">
                                        <input type="hidden" name="Cat_No" id="edit_id"> 
                                        <div class="mb-3">
                                            <label for="edit_name" class="form-label">Category Name</label>
                                            <input type="text" class="form-control" name="Cat_Name" id="edit_name" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="edit_desc" class="form-label">Description</label>
                                            <input type="text" class="form-control" name="Cat_Desc" id="edit_desc" required>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-primary">Update</button>
                                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <!-- End Modal Edit Category -->

                    <!-- Modal Create Sub-Category-->
                    <div class="modal fade" id="modalCreateSubCategory" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered mw-650px">
                            <form class="modal-content" method="POST" action="{{ route('SaveSubCategory') }}">
                                @csrf
                                <div class="modal-header">
                                    <h2>Add New Sub-Category</h2>
                                    <div class="btn btn-sm btn-icon btn-active-light-primary" data-bs-dismiss="modal">
                                        <i class="bi bi-x fs-2"></i>
                                    </div>
                                </div>
                                <div class="modal-body py-10 px-lg-17">
                                    
                                    <!-- Select Category -->
                                    <div class="mb-5">
                                        <label class="form-label">Select Category</label>
                                        <select class="form-select" name="Cat_No" id="selectCategory" data-control="select2" data-placeholder="Select a category" required>
                                            <option></option>
                                            @foreach($category as $cat)
                                                <option value="{{ $cat->Cat_No }}">{{ $cat->Cat_Name }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="mb-5">
                                        <label class="form-label">Sub-Category Name</label>
                                        <input type="text" class="form-control" name="Scat_Name" required />
                                    </div>

                                    <!-- Sub-Category Description -->
                                    <div class="mb-5">
                                        <label class="form-label">Sub-Category Description</label>
                                        <textarea class="form-control" name="Scat_Desc" required></textarea>
                                    </div>
                                </div>

                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-primary">Save</button>
                                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <!-- End Modal -->

                    <!-- Modal Edit SubCategory -->
                    <div class="modal fade" id="modalEditSubCategory" tabindex="-1" aria-labelledby="modalEditSubCategoryLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <form id="editSubCategoryForm" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Edit Sub-Category</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body">
                                        <input type="hidden" name="Scat_No" id="edit_sub_id">

                                        <!-- Select Category -->
                                        <div class="mb-3">
                                            <label for="edit_cat_no" class="form-label">Category</label>
                                            <select class="form-select" name="Cat_No" id="edit_cat_no" data-control="select2" required>
                                                <option></option>
                                                @foreach($category as $cat)
                                                    <option value="{{ $cat->Cat_No }}">{{ $cat->Cat_Name }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <!-- Sub-Category Name -->
                                        <div class="mb-3">
                                            <label for="edit_scat_name" class="form-label">Sub-Category Name</label>
                                            <input type="text" class="form-control" name="Scat_Name" id="edit_scat_name" required>
                                        </div>

                                        <!-- Description -->
                                        <div class="mb-3">
                                            <label for="edit_scat_desc" class="form-label">Description</label>
                                            <input type="text" class="form-control" name="Scat_Desc" id="edit_scat_desc" required>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-primary">Update</button>
                                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>



                </div>
            </div>
        </div>
    </div>

    {{-- Script Delete Sub Category --}}
    <script>
        $(document).ready(function () {
            $('.btn-delete-subcategory').click(function () {
                const id = $(this).data('id');
                const name = $(this).data('name');
                const token = "{{ csrf_token() }}";

                let url = "{{ route('DeleteSubCategory', ['id' => '__ID__']) }}";
                url = url.replace('__ID__', id);

                Swal.fire({
                    title: `Delete Sub-Category "${name}"?`,
                    text: "This action cannot be canceled!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, Delete',
                    cancelButtonText: 'Cancle',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: url,
                            type: 'DELETE',
                            data: { _token: token },
                            success: function (response) {
                                if (response.status === 'success') {
                                    Swal.fire('Deleted!', response.message, 'success')
                                        .then(() => location.reload());
                                } else {
                                    Swal.fire(' Failed!', response.message, 'error');
                                }
                            },
                            error: function () {
                                Swal.fire('Failed!', 'Terjadi kesalahan saat menghapus.', 'error');
                            }
                        });
                    }
                });
            });
        });
    </script>

    <script>
        function editSubCategory(scatNo, scatName, scatDesc, catNo) {
            $('#edit_sub_id').val(scatNo);
            $('#edit_scat_name').val(scatName);
            $('#edit_scat_desc').val(scatDesc);
            $('#edit_cat_no').val(catNo).trigger('change'); 
            $('#modalEditSubCategory').modal('show');
            
            // Set form action (pastikan route-name sesuai)
            const actionUrl = "{{ route('UpdateSubCategory', ':id') }}".replace(':id', scatNo);
            $('#editSubCategoryForm').attr('action', actionUrl);
        }
    </script>

    @include('content.auth.category.partial.createcategoryjs')


@endsection



