   
   <script>
        const BASE_URL = "{{ url('/') }}";
    </script>
    
    <script src="{{ asset('assets/plugins/custom/fslightbox/fslightbox.bundle.js') }}"></script>

    <!-- Script Apprve & Remark Approval WOC -->
    <script>
        // Quill Editor
        var quill = new quill('#kt_docs_quill_basic',{
            modules: {
                toolbar: [
                    [{
                        header: [1,2,false]
                    }],
                    ['bold','italic','underline']
                ]
            },
            placeholder: 'Input Your Remarks Here...',
            theme: 'snow'
        });
        // End Quill Editor

        // Eksekusi Button Approve dan Reject
        document.querySelectorAll('.approve-reject-btn').forEach(button => {
            button.addEventListener('click', function() {
                // Declare Varialbel untuk ambil data dari action yang diterima sistem
                const action = this.getAttribute('data-action');
                const note = quill.root.innerHTML.trim(); //trim() buat buang spasi diawal dan diakhir.
                // Declare Kondisi untuk Remark Quill Editor
                const isNotesEmpty = (notes === '' || notes === '<p><br></p>');

                // Alur Proses
                // #1 Cek Kondisi Remark/Notes/Quill Editor yang dikirimkan ke sistem
                
                // Kondisi Action 'REJECT' dan Quill Editor sesuai dengan yang dideklarasikan pada IsNotesEmpty (KOSONG)
                if (action === 'reject' && isNotesEmpty){
                    swal.fire({
                        icon:  'warning',
                        title: 'Empty Note',
                        text: 'Please input your remarks before reject this document.',
                    });
                    return;
                }

                //#2 Kondisi jika Action yang dikirimkan Sistem = Approve
                // Munculkan confirm Pop Up
                Swal.fire({
                    title: `Are you sure want to ${action.toUpperCase()} this Work Order Completion?`,
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#198754',
                    cancelButtonColor: '#dc3545',
                    confirmButtonText: 'Yes!',
                    cancelButtonText: 'Cancel', 
                    reverseButtons: true,
                }).then((result) => {
                    // Jika Action yang diterima = YES maka lakukan kondisi dibawah ini
                    if(result.isConfirmed){
                        // Ambil dan Simpan data yang dikirimkan User kedalam variabel FormData
                        const formData = {
                            _token: '{{ csrf_token() }}',
                            approvalNotes: notes,
                            action: action
                        };

                        // Kirim data yang disimpan pada variable formData yg dikirimkan oleh user kedalam server/ke route Laravel dengan method POST dan format JSON
                     
                        fetch("{{route('workorder.approveReject',['wo_no' => base64_encode($workOrder->Wo_No)])}}", {
                            method: 'POST',
                            headers: {
                                'Content-type': 'application/json',
                                'Accept': 'application/json',
                            },
                            body: JSON.stringify(formData)
                        })
                        // Cek Respon HTTP 
                        .then(response => {
                            if(!response.ok){
                                throw new error ('HTTP error' + response.status);
                            }
                            return response.json();
                        })
                        // Proses Hasil data Json yang dikirimkan ke Server/Route
                        .then(data => {
                            Swal.fire({
                                icon: 'Success',
                                title: 'Success!',
                                text: data.message,
                                confirmButtonColor: '#198754',
                            }).then(() =>{
                                // Refresh halaman
                                document.getElementById("page_loader").style.display="flex";
                                setTimeout(() =>{
                                    window.location.href = "{{route('?ApprovalListWOC?')}}";
                                }, 1000);
                            });
                        });
                    }
                });
            });
        });
    </script>