{{-- <link href="{{ asset('assets/plugins/global/plugins.bundle.css') }}" rel="stylesheet" type="text/css"/>
<script src="{{ asset('assets/plugins/global/plugins.bundle.js') }}"></script> --}}

{{-- View Image --}}
<script>
    document.addEventListener("DOMContentLoaded", function () {
        var imageModal = document.getElementById("imageModal");
        imageModal.addEventListener("show.bs.modal", function (event) {
            var button = event.relatedTarget;
            var imageUrl = button.getAttribute("data-img");
            document.getElementById("modalImage").src = imageUrl;
        });
    });
</script>

<script>
    $(document).ready(function() {
        $(".approve-reject-btn").click(function(e) {
            e.preventDefault();
            
            let action = $(this).data("action"); // dapetin action dari data attribute
            let caseNo = encodeURIComponent("{{ $case->Case_No }}");
    
            // Ambil isi dari Quill dan masukkan ke hidden input
            let quillContent = quill.root.innerHTML;
            $("#approvalNotes").val(quillContent);
    
            Swal.fire({
                title: (action === "approve") ? "Approve Case?" : "Reject Case?",
                text: (action === "approve") ? "Are you sure you want to approve this case?" : "Are you sure you want to reject this case?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: (action === "approve") ? "Yes, Approve" : "Yes, Reject",
                cancelButtonText: "Cancel"
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: `/cases/${caseNo}/approve-reject`,
                        type: "POST",
                        data: {
                            _token: "{{ csrf_token() }}",
                            action: action,
                            approvalNotes: quillContent
                        },
                        success: function(response) {
                            Swal.fire({
                                title: "Success!",
                                text: response.message,
                                icon: "success"
                            }).then(() => {
                                // Langsung redirect aja tanpa reload
                                window.location.href = "/Case/Approval-list";
                            });
                        },
                        error: function(xhr) {
                            Swal.fire("Error", xhr.responseJSON?.message || "Terjadi kesalahan saat memproses", "error");
                        }
                    });
                }
            });
        });
    });
    </script>


<script>
    var quill;

    $(document).ready(function() {
        quill = new Quill('#kt_docs_quill_basic', {
            theme: 'snow',
            placeholder: 'Write your notes here...',
            modules: {
                toolbar: [['bold', 'italic', 'underline'], ['link', 'blockquote'], [{ 'list': 'ordered'}, { 'list': 'bullet' }]]
            }
        });
    });
</script>



