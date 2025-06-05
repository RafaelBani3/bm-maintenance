    <script src="{{ asset('assets/plugins/custom/fslightbox/fslightbox.bundle.js') }}"></script>

    {{-- Approve / Reject Script --}}
    <script>
        $(document).ready(function () {
            $(".approve-reject-btn").click(function (e) {
                e.preventDefault();

                let action = $(this).data("action");
                let caseNo = btoa("{{ $case->Case_No }}");
                let quillContent = quill.root.innerHTML.trim();
                let plainText = quill.getText().trim();

                if (
                    plainText === "" || 
                    plainText.toLowerCase() === "input your remark or notes here"
                ) {
                    Swal.fire({
                        title: "Remark Required",
                        text: "Please input your remark or notes before proceeding.",
                        icon: "warning",
                        confirmButtonText: "OK",
                        customClass: {
                            confirmButton: "btn btn-warning"
                        },
                        buttonsStyling: false
                    });
                    return; 
                }

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
                                // url: `/BmMaintenance/public/cases/${caseNo}/approve-reject`,
                                url: `{{ route('cases.approveReject', '__CASE_NO__') }}`.replace('__CASE_NO__', caseNo),
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
                                        // window.location.href = `${BASE_URL}/Case/Approval-list`;
                                        window.location.href = `{{ route('ApprovalCase') }}`;
                                    });
                                },
                                error: function (xhr) {
                                    $("#page_loader").hide();
                                    Swal.fire("Warning", xhr.responseJSON?.message || "An error occurred while processing", "error");
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
            modules: {
                toolbar: [
                    [{
                    header: [1, 2, false]
                    }],
                    ['bold', 'italic', 'underline'],
                    ['image', 'code-block']
                ]
            },
            placeholder: 'Input Your Remarks Here...',
            theme: 'snow' 
        });
    </script>

  