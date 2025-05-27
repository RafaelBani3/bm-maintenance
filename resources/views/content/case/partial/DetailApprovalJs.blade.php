<<<<<<< HEAD
{{-- <link href="{{ asset('assets/plugins/global/plugins.bundle.css') }}" rel="stylesheet" type="text/css"/>
<script src="{{ asset('assets/plugins/global/plugins.bundle.js') }}"></script> --}}
<script src="{{ asset('assets/plugins/custom/fslightbox/fslightbox.bundle.js') }}"></script>

{{-- View Image --}}
{{-- <script>
    document.addEventListener("DOMContentLoaded", function () {
        var imageModal = document.getElementById("imageModal");
        imageModal.addEventListener("show.bs.modal", function (event) {
            var button = event.relatedTarget;
            var imageUrl = button.getAttribute("data-img");
            document.getElementById("modalImage").src = imageUrl;
        });
    });
</script> --}}

{{-- Approve Case --}}
<script>
    $(document).ready(function() {
        $(".approve-reject-btn").click(function(e) {
            e.preventDefault();
            
            let action = $(this).data("action");
            let caseNo = btoa("{{ $case->Case_No }}"); 
    
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
                        url: `/BmMaintenance/public/cases/${caseNo}/approve-reject`,
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
                                window.location.href = `${BASE_URL}/Case/Approval-list`;
                    
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

{{-- Script Untuk Text Area(Remark) --}}
{{-- <script>
    var quill;

    $(document).ready(function() {
        quill = new Quill('#kt_docs_quill_basic', {
            theme: 'snow',
            placeholder: 'Write your notes here...',
=======
    {{-- <link href="{{ asset('assets/plugins/global/plugins.bundle.css') }}" rel="stylesheet" type="text/css"/>
    <script src="{{ asset('assets/plugins/global/plugins.bundle.js') }}"></script> --}}
    <script src="{{ asset('assets/plugins/custom/fslightbox/fslightbox.bundle.js') }}"></script>

    {{-- View Image --}}
    {{-- <script>
        document.addEventListener("DOMContentLoaded", function () {
            var imageModal = document.getElementById("imageModal");
            imageModal.addEventListener("show.bs.modal", function (event) {
                var button = event.relatedTarget;
                var imageUrl = button.getAttribute("data-img");
                document.getElementById("modalImage").src = imageUrl;
            });
        });
    </script> --}}

    {{-- Approve Case --}}
    {{-- <script>
        $(document).ready(function() {
            $(".approve-reject-btn").click(function(e) {
                e.preventDefault();
                
                let action = $(this).data("action");
                let caseNo = btoa("{{ $case->Case_No }}"); 
        
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
                            url: `/BmMaintenance/public/cases/${caseNo}/approve-reject`,
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
                                    window.location.href = `${BASE_URL}/Case/Approval-list`;
                        
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
    </script> --}}

    {{-- Approve / Reject Script --}}
    <script>
        $(document).ready(function () {
            $(".approve-reject-btn").click(function (e) {
                e.preventDefault();

                let action = $(this).data("action");
                let caseNo = btoa("{{ $case->Case_No }}");
                let quillContent = quill.root.innerHTML;

                $("#page_loader").css("display", "flex");

                setTimeout(() => {
                    $("#page_loader").hide();

                    Swal.fire({
                        title: (action === "approve") ? "Approve Case?" : "Reject Case?",
                        text: (action === "approve") ? "Are you sure you want to approve this case?" : "Are you sure you want to reject this case?",
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonText: (action === "approve") ? "Yes, Approve" : "Yes, Reject",
                        cancelButtonText: "Cancel",
                        reverseButtons: true,
                        customClass: {
                            confirmButton: "btn btn-primary",
                            cancelButton: "btn btn-danger"    
                        },
                        buttonsStyling: false
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $("#page_loader").css("display", "flex");

                            $.ajax({
                                url: `/BmMaintenance/public/cases/${caseNo}/approve-reject`,
                                type: "POST",
                                data: {
                                    _token: "{{ csrf_token() }}",
                                    action: action,
                                    approvalNotes: quillContent
                                },
                                success: function (response) {
                                    $("#page_loader").hide();
                                    Swal.fire({
                                        title: "Success!",
                                        text: response.message,
                                        icon: "success",
                                        
                                    }).then(() => {
                                        window.location.href = `${BASE_URL}/Case/Approval-list`;
                                    });
                                },
                                error: function (xhr) {
                                    $("#page_loader").hide();
                                    Swal.fire("warning", xhr.responseJSON?.message || "An error occurred while processing", "error");
                                }
                            });
                        }
                    });
                }, 1000); 
            });
        });
    </script>

    {{-- Script Untuk Text Area(Remark) --}}
    <script>
        var quill = new Quill('#kt_docs_quill_basic', {
>>>>>>> ff25b43 (Update)
            modules: {
                toolbar: [
                    [{
                    header: [1, 2, false]
                    }],
                    ['bold', 'italic', 'underline'],
                    ['image', 'code-block']
                ]
            },
            placeholder: 'Type your text here...',
            theme: 'snow' 
        });
<<<<<<< HEAD
    });
</script> --}}
=======
    </script>
>>>>>>> ff25b43 (Update)

