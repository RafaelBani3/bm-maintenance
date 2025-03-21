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

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
$(document).ready(function() {
    $(".approve-reject-btn").click(function(e) {
        e.preventDefault();
        
        let action = $(this).val();
        let caseNo = encodeURIComponent("{{ $case->Case_No }}");
        let approvalNotes = $("#approvalNotes").val();

        Swal.fire({
            title: (action === "approve") ? "Approve Case?" : "Reject Case?",
            text: (action === "approve") ? "Are you sure you want to approve this case?" : "Are you sure you want to reject this case?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: (action === "approve") ? "Yes, Approve" : "Yes, Reject",
            cancelButtonText: "Cancle"
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: `/cases/${caseNo}/approve-reject`,
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        action: action,
                        approvalNotes: approvalNotes
                    },
                    success: function(response) {
                        Swal.fire({
                            title: "Success!",
                            text: response.message,
                            icon: "success"
                        }).then(() => {
                            location.reload(); 
                            window.location.href = "/Case/Approval-list";
                        });
                    },
                    error: function(xhr) {
                        Swal.fire("Error", xhr.responseJSON.message, "error");
                    }
                });
            }
        });
    });
});
</script>



