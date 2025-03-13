
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
     
{{-- // Save Handling Script --}}
 <script>
    $(document).ready(function() {
        $('#caseForm').on('submit', function(e) {
            e.preventDefault();
            var formData = new FormData(this);
            
            $('.form-control, .form-select').removeClass('is-invalid');
            $('.invalid-feedback').text('');

            $.ajax({
                url: "{{ route('case.validate') }}",
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    if (response.success) {
                        saveCase(formData);
                    }
                },
                error: function(xhr) {
                    if (xhr.status === 422) {
                        var errors = xhr.responseJSON.errors;
                        $.each(errors, function(field, messages) {
                            if (field.includes('.')) {
                                field = field.split('.')[0];
                            }
                            
                            $('#' + field).addClass('is-invalid');
                            $('#error-' + field).text(messages[0]);
                        });
                        
                        if ($('.is-invalid').length) {
                            $('html, body').animate({
                                scrollTop: $('.is-invalid:first').offset().top - 100
                            }, 200);
                        }
                    }
                }
            });
        });

        function saveCase(formData) {
            $.ajax({
                url: "{{ route('SaveCase') }}",
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    if (response.success) {
                        Swal.fire({
                            title: 'Success!',
                            text: response.message,
                            icon: 'success',
                            confirmButtonText: 'OK'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                let encodedCaseNo = encodeURIComponent(response.case_no);
                                window.location.href = "/Case-Report/Edit?case_no=" + encodedCaseNo;
                            }
                        });
                    }
                },
                error: function(xhr) {
                    console.log(xhr.responseText); 
                    Swal.fire({
                        title: 'Error',
                        text: 'Failed to save case. Please try again.',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                }
            });
        }

        // Clear validation errors when user starts typing or selecting
        $('.form-control, .form-select').on('input change', function() {
            $(this).removeClass('is-invalid');
            $('#error-' + $(this).attr('id')).text('');
        });
    });
</script>
{{-- End Script Save --}}

{{-- Category & Subcategory Handling Script --}}
<script>
    $(document).ready(function() {
        $('#category').change(function() {
            var cat_no = $(this).val();
            if (cat_no) {
                $.ajax({
                    url: '/get-subcategories/' + cat_no,
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        $('#sub_category').html('<option value="">Choose Sub Category</option>');
                        $.each(data, function(key, subcat) {
                            $('#sub_category').append('<option value="' + subcat.Scat_No + '">' + subcat.Scat_Name + '</option>');
                        });
                        $('#sub_category').prop('disabled', false);
                    }
                });
            } else {
                $('#sub_category').html('<option value="">You Should Choose Category First</option>').prop('disabled', true);
            }
        });
    });
</script>
{{-- end Category & Subcategory Handling Script --}}

{{-- Notification Category & Subcategory Handling Script --}}
<script>
    document.getElementById('category').addEventListener('change', function() {
            let subCategory = document.getElementById('sub_category');
            if (this.value) {
                subCategory.disabled = false;
                // Swal.fire({
                //     icon: 'success',
                //     title: 'Kategori dipilih!',
                //     text: 'Silakan pilih sub kategori.',
                // });
            } else {
                subCategory.disabled = true;
                Swal.fire({
                    icon: 'warning',
                    title: 'You Should Choose Category First!',
                    timer: 2000,
                });
            }
        });
</script>
{{-- End Notficatin Category & Subcategory Handling Script --}}

{{-- // Image Preview Handling Script --}}
<script>
    let selectedImageIndex = null;

    function previewImages() {
        let input = document.getElementById('photos');
        let preview = document.getElementById('photo-preview');
        let errorMsg = document.getElementById('error-photos');

        preview.innerHTML = '';
        errorMsg.innerText = '';

        let files = input.files;
        let allowedTypes = ['image/png', 'image/jpg', 'image/jpeg'];

        if (files.length > 5) {
            errorMsg.innerText = "Maksimal upload 5 gambar!";
            input.value = ''; 
            Swal.fire({
                icon: 'error',
                title: 'Oops!',
                text: 'Maksimal upload hanya 5 gambar!',
                timer: 2500,
                showConfirmButton: false
            });
            return;
        }

        for (let file of files) {
            if (!allowedTypes.includes(file.type)) {
                errorMsg.innerText = "Format harus PNG, JPG, atau JPEG!";
                input.value = ''; 
                Swal.fire({
                    icon: 'error',
                    title: 'Format Tidak Didukung!',
                    text: 'Hanya diperbolehkan PNG, JPG, atau JPEG!',
                    timer: 2500,
                    showConfirmButton: false
                });
                return;
            }

            let reader = new FileReader();
            reader.onload = function(e) {
                let img = document.createElement('img');
                img.src = e.target.result;
                img.style.width = '100%';
                img.style.maxWidth = '300px';
                img.style.height = '320px';
                img.style.objectFit = 'cover';
                img.classList.add('img-thumbnail', 'm-1', 'preview-image');

                img.onclick = function() {
                    showImageModal(e.target.result);
                };

                preview.appendChild(img);
            };
            reader.readAsDataURL(file);
        }
    }

    function showImageModal(src) {
        let modalImage = document.getElementById('modal-image');
        modalImage.src = src;
        let imageModal = new bootstrap.Modal(document.getElementById('imageModal'));
        imageModal.show();
    }
</script>
{{-- End Image Preview Handling Script --}}

@if(session('success'))
    <script>
        Swal.fire({
            title: "Success!",
            text: "{{ session('success') }}",
            icon: "success",
            timer: 2000,
            showConfirmButton: false
        });
    </script>
@endif
