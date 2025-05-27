<<<<<<< HEAD
<!-- NOTIFICATION DROPDOWN -->
<div class="menu menu-sub menu-sub-dropdown menu-column w-500px w-lg-550px" data-kt-menu="true" 
    id="kt_menu_notifications" style="position: relative;">

    <div class="d-flex flex-column bgi-no-repeat rounded-top" style="background-color:burlywood">
        <h3 class="text-white fw-semibold px-9 mt-10 mb-6">Notifications 
        <span class="fs-8 opacity-75 ps-3" id="notification-count">0 reports</span></h3>
    </div>
=======
    
    <!-- NOTIFICATION DROPDOWN -->
    <div class="menu menu-sub menu-sub-dropdown menu-column w-500px w-lg-600px" data-kt-menu="true" 
        id="kt_menu_notifications" style="position: relative;">
>>>>>>> ff25b43 (Update)

        <div class="d-flex flex-column bgi-no-repeat rounded-top" style="background-color:burlywood">
            <h3 class="text-white fw-semibold px-9 mt-10 mb-6">Notifications 
            <span class="fs-8 opacity-75 ps-3" id="notification-count">0 reports</span></h3>
        </div>

        <div class="tab-content">
            <div class="tab-pane fade show active" id="kt_topbar_notifications_1" role="tabpanel">
                <div class="scroll-y mh-325px my-5 px-8" id="notification-list">
                    <!-- Notifikasi -->
                </div>       
            </div>
        </div>
    </div>

<<<<<<< HEAD
{{-- Get Notification --}}
{{-- <script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    function fetchNotifications() {
        $.ajax({
            url: '{{ route('Notifications') }}', 
            method: 'GET',
            success: function(response) {
                $('#notification-list').empty();
                $('#notification-count').text(response.notifications.length + ' reports');

                const baseUrl = window.location.origin + "/BmMaintenance/public";

                response.notifications.forEach(function(notification) {
                    const referenceNoEncoded = btoa(notification.reference_no);

                    let detailUrl = '#';
                    if (notification.Notif_Type === 'BA') {
                        detailUrl = `${baseUrl}/Case/Approval/Detail/${referenceNoEncoded}`;
                    } else if (notification.Notif_Type === 'WO') {
                        detailUrl = `${baseUrl}/WorkOrder/Approval/Detail/${referenceNoEncoded}`;
                    } else if (notification.Notif_Type === 'MR') {
                        detailUrl = `${baseUrl}/MaterialRequest/Approval/Detail/${referenceNoEncoded}`;
                    }

                    const notificationItem = `
                        <div class="d-flex justify-content-between align-items-start py-4 border-bottom notification-item"
                            style="cursor: pointer;"
                            onclick="window.location.href='${detailUrl}'">
=======
    {{-- Get Notification --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script>
        const userPermissions = @json(Auth::user()->getAllPermissions()->pluck('name'));
    </script>
    
    <script>
        $(document).ready(function () {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            function fetchNotifications() {
                $.ajax({
                    url: '{{ route('Notifications') }}',
                    method: 'GET',
                    // success: function(response) {
                    //     $('#notification-list').empty();
                    //     $('#notification-count').text(response.notifications.length + ' reports');
>>>>>>> ff25b43 (Update)

                    //     const baseUrl = window.location.origin + "/BmMaintenance/public";

                    //     response.notifications.forEach(function(notification) {
                    //         const referenceNoEncoded = btoa(notification.reference_no);

                    //         // let detailUrl = '#';
                    //         // if (notification.Notif_Type === 'BA') {
                    //         //     detailUrl = `${baseUrl}/Case/Approval/Detail/${referenceNoEncoded}`;
                    //         // } else if (notification.Notif_Type === 'WO') {
                    //         //     detailUrl = `${baseUrl}/WorkOrder/Approval/Detail/${referenceNoEncoded}`;
                    //         // } else if (notification.Notif_Type === 'MR') {
                    //         //     detailUrl = `${baseUrl}/Material-Request/Approval-Detail/${referenceNoEncoded}`;
                    //         // }

                    //         if (notification.Notif_Type === 'BA' && userPermissions.includes('view cr_ap')) {
                    //             detailUrl = `${baseUrl}/Case/Approval/Detail/${referenceNoEncoded}`;
                    //         } else if (notification.Notif_Type === 'WO' && userPermissions.includes('view wo_ap')) {
                    //             detailUrl = `${baseUrl}/WorkOrder/Approval/Detail/${referenceNoEncoded}`;
                    //         } else if (notification.Notif_Type === 'MR' && userPermissions.includes('view mr_ap')) {
                    //             detailUrl = `${baseUrl}/Material-Request/Approval-Detail/${referenceNoEncoded}`;
                    //         } else if (notification.Notif_Type === 'BA' && userPermissions.includes('view mr')) {
                    //             detailUrl = `${baseUrl}/Case/Detail/${referenceNoEncoded}`;
                    //         } else if (notification.Notif_Type === 'MR' && userPermissions.includes('view mr')) {
                    //             detailUrl = `${baseUrl}/Material-Request/Detail/${referenceNoEncoded}`;
                    //         } else if (notification.Notif_Type === 'WO' && userPermissions.includes('view wo')) {
                    //         detailUrl = `${baseUrl}/WorkOrder-Complition/Detail/${referenceNoEncoded}`;

                    //         const notificationItem = `
                    //             <div class="d-flex justify-content-between align-items-start py-4 border-bottom notification-item"
                    //                 style="cursor: pointer;"
                    //                 data-notif-no="${notification.Notif_No}"
                    //                 data-detail-url="${detailUrl}">

                    //                 <div class="d-flex align-items-start">
                    //                     <div class="symbol symbol-35px me-4 mt-1">
                    //                         <span class="symbol-label bg-light-primary">
                    //                             <i class="fas fa-bell fs-4 text-primary"></i>
                    //                         </span>
                    //                     </div>

                    //                     <div class="d-flex flex-column">
                    //                         <span class="fw-semibold text-gray-800 text-hover-primary">${notification.Notif_Title}</span>
                    //                         <span class="fs-7 text-muted">${notification.Notif_Text}</span>
                    //                         <span class="fs-8 text-gray-400 mt-1">${notification.Notif_Date}</span>
                    //                     </div>
                    //                 </div>

                    //                 <div class="ms-2 mt-1">
                    //                     <button class="btn btn-icon btn-sm btn-light-danger btn-dismiss"
                    //                             data-id="${notification.Notif_No}">
                    //                         <i class="fas fa-trash-alt"></i>
                    //                     </button>
                    //                 </div>
                    //             </div>
                    //         `;

                    //         $('#notification-list').append(notificationItem);
                    //     });
                    // },
                    success: function(response) {
                        $('#notification-list').empty();
                        $('#notification-count').text(response.notifications.length + ' reports');

                        if (response.notifications.length === 0) {
                            const noNotifMessage = `
                                <div class="alert alert-info text-center" role="alert">
                                    <i class="fas fa-info-circle me-2"></i> No notifications found
                                </div>
                            `;
                            $('#notification-list').append(noNotifMessage);
                            return;
                        }

                        const baseUrl = window.location.origin + "/BmMaintenance/public";

                        response.notifications.forEach(function(notification) {
                            const referenceNoEncoded = btoa(notification.reference_no);
                            let detailUrl = '#';

                            if (notification.Notif_Type === 'BA' && userPermissions.includes('view cr_ap')) {
                                detailUrl = `${baseUrl}/Case/Approval/Detail/${referenceNoEncoded}`;
                            } else if (notification.Notif_Type === 'WO' && userPermissions.includes('view cr_ap')) {
                                detailUrl = `${baseUrl}/WorkOrder-Complition/DetailApprovalWOC/${referenceNoEncoded}`;
                            } else if (notification.Notif_Type === 'MR' && userPermissions.includes('view mr_ap')) {
                                detailUrl = `${baseUrl}/Material-Request/Approval-Detail/${referenceNoEncoded}`;
                            } else if (notification.Notif_Type === 'BA' && userPermissions.includes('view cr')) {
                                detailUrl = `${baseUrl}/Case/Detail/${referenceNoEncoded}`;
                            } else if (notification.Notif_Type === 'MR' && userPermissions.includes('view mr')) {
                                detailUrl = `${baseUrl}/Material-Request/Detail/${referenceNoEncoded}`;
                            } else if (notification.Notif_Type === 'WO' && userPermissions.includes('view cr')) {
                                detailUrl = `${baseUrl}/WorkOrder-Complition/Detail/${referenceNoEncoded}`;
                            }

                            const notificationItem = `
                                <div class="d-flex justify-content-between align-items-start py-4 border-bottom notification-item"
                                    style="cursor: pointer;"
                                    data-notif-no="${notification.Notif_No}"
                                    data-detail-url="${detailUrl}">

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
                                        <button class="btn btn-icon btn-sm btn-light-danger btn-dismiss"
                                                data-id="${notification.Notif_No}">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </div>
                                </div>
                            `;

<<<<<<< HEAD
                            <div class="ms-2 mt-1">
                                <button class="btn btn-icon btn-sm btn-light-danger"
                                        onclick="event.stopPropagation(); dismissNotification(${notification.id})">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </div>
                        </div>
                    `;
=======
                            $('#notification-list').append(notificationItem);
                        });
                    },
>>>>>>> ff25b43 (Update)

                    error: function(xhr, status, error) {
                        console.error('Gagal mengambil notifikasi:', error);
                    }
                });
<<<<<<< HEAD
            },
            error: function(xhr, status, error) {
                console.error('Gagal mengambil notifikasi:', error);
=======
>>>>>>> ff25b43 (Update)
            }

            setInterval(fetchNotifications, 75000);
            fetchNotifications();

            $(document).on('click', '.notification-item', function () {
                const notifNo = $(this).data('notif-no');
                const detailUrl = $(this).data('detail-url');

                $.ajax({
                    url: '{{ url("/notification/read") }}/' + notifNo,
                    method: 'POST',
                    success: function(response) {
                        window.location.href = detailUrl;
                    },
                    error: function(err) {
                        alert('Gagal menandai notifikasi sebagai dibaca.');
                        console.error(err);
                        window.location.href = detailUrl; 
                    }
                });
            });
        });
<<<<<<< HEAD
    }

    // function goToDetail(caseNo) {
    //     if (!caseNo || caseNo === 'undefined') {
    //         alert("Case number tidak tersedia.");
    //         return;
    //     }

    //     window.location.href = `/Case/Approval/Detail/${caseNo}`;
    // }

    function dismissNotification(id) {
        console.log("Dismiss notification id:", id);
    }

    setInterval(fetchNotifications, 5000);
    fetchNotifications();
</script> --}}

<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    
    function fetchNotifications() {
        $.ajax({
            url: '{{ route('Notifications') }}',
            method: 'GET',
            success: function(response) {
                $('#notification-list').empty();
                $('#notification-count').text(response.notifications.length + ' reports');

                const baseUrl = window.location.origin + "/BmMaintenance/public";

                response.notifications.forEach(function(notification) {
                    const referenceNoEncoded = btoa(notification.reference_no);

                    let detailUrl = '#';
                    if (notification.Notif_Type === 'BA') {
                        detailUrl = `${baseUrl}/Case/Approval/Detail/${referenceNoEncoded}`;
                    } else if (notification.Notif_Type === 'WO') {
                        detailUrl = `${baseUrl}/WorkOrder/Approval/Detail/${referenceNoEncoded}`;
                    } else if (notification.Notif_Type === 'MR') {
                        detailUrl = `${baseUrl}/MaterialRequest/Approval/Detail/${referenceNoEncoded}`;
                    }

                    const notificationItem = `
                        <div class="d-flex justify-content-between align-items-start py-4 border-bottom notification-item"
                            style="cursor: pointer;"
                            onclick="handleNotificationClick(${notification.Notif_No}, '${detailUrl}')">

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
                console.error('Gagal mengambil notifikasi:', error);
            }
        });
    }

    function handleNotificationClick(id, url) {
        console.log("Sending mark-as-read for Notif_No:", id);

        $.ajax({
            url: '/BmMaintenance/public/notification/read/' + id,
            method: 'POST',
            success: function(response) {
                console.log("Mark-as-read success:", response);
                window.location.href = url;
            },
            error: function(err) {
                console.error("Gagal update Notif_IsRead:", err);
                window.location.href = url;
            }
        });
    }


    function dismissNotification(id) {
        console.log("Dismiss notification id:", id);
    }

    setInterval(fetchNotifications, 5000);
    fetchNotifications();
</script>

=======
    </script>


>>>>>>> ff25b43 (Update)
