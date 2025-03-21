
<script>
    function openExistingModal(index, src, imgId) {
        document.getElementById('existing-modal-image').src = src;
        document.getElementById('current-image-id').value = imgId;
        const modal = new bootstrap.Modal(document.getElementById('existingImageModal'));
        modal.show();
    }

    function openModal(index, src) {
        selectedImageIndex = index;
        document.getElementById('modal-image').src = src;
        const modal = new bootstrap.Modal(document.getElementById('imageModal'));
        modal.show();
    }

    document.addEventListener('DOMContentLoaded', function() {
        const categorySelect = document.getElementById('category');
        const subCategorySelect = document.getElementById('sub_category');
        
        categorySelect.addEventListener('change', function() {
            const categoryId = this.value;
            
            subCategorySelect.innerHTML = '<option value="">Choose Sub Category</option>';
            
            if (categoryId) {
                subCategorySelect.disabled = false;
                
                fetch(`/get-subcategories/${categoryId}`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.length > 0) {
                            data.forEach(subcat => {
                                const option = document.createElement('option');
                                option.value = subcat.Scat_No;
                                option.textContent = subcat.Scat_Name;
                                subCategorySelect.appendChild(option);
                            });
                        }
                    })
                    .catch(error => console.error('Error fetching subcategories:', error));
            } else {
                subCategorySelect.disabled = true;
            }
        });
        
        if (categorySelect.value) {
            subCategorySelect.disabled = false;
        }
    });
</script>


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