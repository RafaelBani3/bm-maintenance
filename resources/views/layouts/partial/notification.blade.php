<div class="menu menu-sub menu-sub-dropdown menu-column w-500px w-lg-550px" data-kt-menu="true" 
    id="kt_menu_notifications" style="position: relative;">
    
    <div class="d-flex flex-column bgi-no-repeat rounded-top" style="background-color:burlywood">
        <h3 class="text-white fw-semibold px-9 mt-10 mb-6">Notifications 
        <span class="fs-8 opacity-75 ps-3" id="notification-count">0 reports</span></h3>
    </div>

    <div class="tab-content">
        <div class="tab-pane fade show active" id="kt_topbar_notifications_1" role="tabpanel">
            <div class="scroll-y mh-325px my-5 px-8" id="notification-list">
                <!-- Notifikasi akan muncul di sini -->
            </div>       
        </div>
    </div>
</div>

<script>
    function fetchNotifications() {
        $.ajax({
            url: '{{ route('Notifications') }}',  
            method: 'GET',
            success: function(response) {
                $('#notification-list').empty();
                $('#notification-count').text(response.notifications.length + ' reports');

                response.notifications.forEach(function(notification) {
                    var notificationItem = `
                        <div class="d-flex justify-content-between align-items-start py-4 border-bottom notification-item" 
                            style="cursor: pointer;" 
                            onclick="goToDetail('${notification.Case_No}')">

                            <div class="d-flex align-items-start">
                                <div class="symbol symbol-35px me-4 mt-1">
                                    <span class="symbol-label bg-light-primary">
                                        <i class="fas fa-bell fs-4 text-primary"></i>
                                    </span>
                                </div>

                                <div class="d-flex flex-column">
                                    <span class="fw-semibold text-gray-800 text-hover-primary">${notification.Notif_Title}</span>
                                    <span class="fs-7 text-muted">${notification.Notif_Text}</span>
                                    <span class="fs-8 text-gray-400 mt-1">${notification.Notif_Date}</span>
                                </div>
                            </div>

                            <div class="ms-2 mt-1">
                                <button class="btn btn-icon btn-sm btn-light-danger" 
                                        onclick="event.stopPropagation(); dismissNotification(${notification.id})">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </div>
                        </div>
                    `;

                    $('#notification-list').append(notificationItem);
                });
            },
            error: function(xhr, status, error) {
                console.log('Error fetching notifications: ' + error);
            }
        });
    }

    setInterval(fetchNotifications, 5000);
    fetchNotifications();
</script>

<script>
$.ajax({
    url: '/Case/Detail',
    method: 'POST',
    data: {
        _token: '{{ csrf_token() }}',
        case_no: caseNo
    },
    dataType: 'json', // <--- Tambah ini biar pasti dibaca JSON
    success: function (response) {
        console.log(response);
        if (response.redirect) {
            window.location.href = response.redirect;
        } else {
            alert('Unexpected response.');
        }
    },
    error: function (xhr) {
        console.error('AJAX Error:', xhr.responseText);
        alert('Gagal membuka detail case.');
    }
});

</script>


