    {{-- Script Table Category --}}
    <script>
        $(document).ready(function () {
            $('#kt_datatable_horizontal_scroll').DataTable({
                "scrollX": true,
                "pageLength": 5,
                "order": [[3, "desc"]],
                "language": {
                    "search": "Search User:",
                    "lengthMenu": "Show _MENU_ entries",
                    "info": "Showing _START_ to _END_ of _TOTAL_ Categories",
                }
            });
        });
    </script>

    {{-- Script Table SubCategory --}}
    <script>
        $(document).ready(function () {
            $('#kt_datatable_horizontal_scroll_2').DataTable({
                "scrollX": true,
                "pageLength": 5,
                "order": [[4, "desc"]],
                "fixedColumns": {
                    "right": 1,
                },
                "language": {
                    "search": "Search User:",
                    "lengthMenu": "Show _MENU_ entries",
                    "info": "Showing _START_ to _END_ of _TOTAL_ Sub-Categories",
                }
            });
        });
    </script>
    
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link href="{{ asset('assets/plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css"/>
    <script src="{{ asset('assets/plugins/custom/datatables/datatables.bundle.js') }}"></script>

    {{-- Script Update Category --}}
    <script>
        $(document).ready(function () {
            $('.btn-edit-category').click(function () {
                const id = $(this).data('id');
                const name = $(this).data('name');
                const desc = $(this).data('desc');

                $('#edit_id').val(id);
                $('#edit_name').val(name);
                $('#edit_desc').val(desc);

                let updateUrl = "{{ route('UpdateCategory', ['id' => '__ID__']) }}";
                updateUrl = updateUrl.replace('__ID__', id);
                $('#editCategoryForm').attr('action', updateUrl);
            });

            $('#editCategoryForm').submit(function (e) {
                e.preventDefault();

                const form = $(this);
                const url = form.attr('action');
                const data = form.serialize();

                $.ajax({
                    url: url,
                    type: 'POST',
                    data: data,
                    beforeSend: function () {
                        $('#modalEditCategory').modal('hide'); 
                    },
                    success: function (response) {
                        setTimeout(() => {
                            Swal.fire({
                                icon: 'success',
                                title: 'Success',
                                text: 'Category Updated Succesfully.',
                            }).then(() => location.reload());
                        }, 300);
                    },
                    error: function (xhr) {
                        let msg = 'Terjadi kesalahan.';
                        if (xhr.responseJSON && xhr.responseJSON.errors) {
                            const errors = xhr.responseJSON.errors;
                            msg = Object.values(errors).flat().join('\n');
                        }

                        $('#modalEditCategory').modal('hide');
                        setTimeout(() => {
                            Swal.fire('Gagal!', msg, 'error');
                        }, 300);
                    }
                });
            });
        });
    </script>

    {{-- Hapus Category --}}
    <script>
        $(document).ready(function () {
            $('.btn-delete-category').click(function () {
                const id = $(this).data('id');
                const name = $(this).data('name');
                const token = "{{ csrf_token() }}";

                let url = "{{ route('DeleteCategory', ['id' => '__ID__']) }}";
                url = url.replace('__ID__', id);

                Swal.fire({
                    title: `Delete Category "${name}"?`,
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
