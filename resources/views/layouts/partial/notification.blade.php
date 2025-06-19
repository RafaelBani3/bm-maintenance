    <!-- NOTIFICATION DROPDOWN -->
    {{-- <div class="menu menu-sub menu-sub-dropdown menu-column w-500px w-lg-600px" data-kt-menu="true" 
        id="kt_menu_notifications" style="position: relative;">

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
    </div> --}}

    <div class="menu menu-sub menu-sub-dropdown menu-column w-500px w-lg-600px shadow" data-kt-menu="true" 
        id="kt_menu_notifications" style="position: relative;">

        <!-- Header -->
        <div class="d-flex flex-column rounded-top" style="background-color:maroon;">
            <h3 class="text-white fw-bold px-9 pt-9 pb-5">
                Notifications 
                <span class="fs-8 opacity-75 ps-3" id="notification-count">0 reports</span>
            </h3>
        </div>

        <!-- Body -->
        <div class="tab-content">
            <div class="tab-pane fade show active" id="kt_topbar_notifications_1" role="tabpanel">
                <div class="scroll-y mh-325px my-5 px-6" id="notification-list">
                    <!-- Notifikasi diinject via JS -->
                </div>
            </div>
        </div>
    </div>


    {{-- Get Notification --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <script>
        const userPermissions = @json(Auth::user()->getAllPermissions()->pluck('name'));
    </script>

    {{-- Script Get Notif & Direct to Detail Notif --}}
    {{-- <script>
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
                success: function(response) {
                    $('#notification-list').empty();
                    $('#notification-count').text(response.notifications.length + ' reports');

                    // === Update Notif Badge ===
                    const badge = $('#notif-badge');
                    const count = response.notifications.length;

                    if (count > 0) {
                        badge.text(count);
                        badge.removeClass('d-none');
                    } else {
                        badge.text('0');
                        badge.addClass('d-none');
                    }

                    if (count === 0) {
                        $('#notification-list').append(`
                            <div class="alert alert-info text-center" role="alert">
                                <i class="fas fa-info-circle me-2"></i> No notifications found
                            </div>
                        `);
                        return;
                    }

                    // === Route Declarations ===
                    const approvalDetailRoute     = @json(route('approvaldetail'));
                    const wocDetailApprovalRoute  = @json(route('woc.detail.approval', ['encodedWO' => 'PLACEHOLDER']));

                    const approvalDetailMRRoute   = @json(route('ApprovalDetailMR', ['encodedMRNo' => 'PLACEHOLDER']));
                    const caseDetailRoute         = @json(route('case.detail', ['case_no' => 'PLACEHOLDER']));
                    const mrDetailRoute           = @json(route('MaterialRequest.Detail', ['encodedMRNo' => 'PLACEHOLDER']));
                    const wocDetailRoute          = @json(route('WocDetail', ['wo_no' => 'PLACEHOLDER']));
                    
                    response.notifications.forEach(function(notification) {
                        let detailUrl = '#';
                        const rawRef = notification.reference_no;
                        const encodedRef = btoa(rawRef);

                        if (notification.Notif_Type === 'BA' && userPermissions.includes('view cr_ap')) {
                            detailUrl = `${approvalDetailRoute}/${encodedRef}`;
                        } 
                        else if (notification.Notif_Type === 'WO' && userPermissions.includes('view cr_ap')) {
                            detailUrl = wocDetailApprovalRoute.replace('PLACEHOLDER', encodedRef);
                        } 
                        else if (notification.Notif_Type === 'MR' && userPermissions.includes('view mr_ap')) {
                            detailUrl = approvalDetailMRRoute.replace('PLACEHOLDER', encodedRef);
                        } 
                        else if (notification.Notif_Type === 'BA' && userPermissions.includes('view cr')) {
                            detailUrl = caseDetailRoute.replace('PLACEHOLDER', encodedRef);
                        } 
                        else if (notification.Notif_Type === 'MR' && userPermissions.includes('view mr')) {
                            detailUrl = mrDetailRoute.replace('PLACEHOLDER', encodedRef);
                        } 
                        else if (notification.Notif_Type === 'WO' && userPermissions.includes('view cr')) {
                            detailUrl = wocDetailRoute.replace('PLACEHOLDER', encodedRef); // tanpa base64
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
                                    <button class="btn btn-icon btn-sm btn-light-success btn-mark-read" 
                                            data-bs-toggle="tooltip" 
                                            title="Mark as Read" 
                                            data-id="${notification.Notif_No}">
                                        <i class="fas fa-check-circle text-success"></i>
                                    </button>
                                </div>
                            </div>
                        `;
                        $('#notification-list').append(notificationItem);
                        $('[data-bs-toggle="tooltip"]').tooltip();

                    });
                },
                error: function(xhr, status, error) {
                    console.error('Gagal mengambil notifikasi:', error);
                }
            });
        }

        // Load awal dan setiap 75 detik
        setInterval(fetchNotifications, 75000);
        fetchNotifications();

        // Klik notifikasi → tandai terbaca & redirect
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
                    console.error('Gagal menandai notifikasi sebagai dibaca:', err);
                    window.location.href = detailUrl;
                }
            });
        });

        // Klik tombol "Mark as Read"
        $(document).on('click', '.btn-mark-read', function (e) {
            e.stopPropagation(); 

            const notifNo = $(this).data('id');

            $.ajax({
                url: '{{ url("/notification/mark-as-read") }}/' + notifNo,
                method: 'POST',
                success: function (response) {
                    $(`.notification-item[data-notif-no="${notifNo}"]`).fadeOut(300, function () {
                        $(this).remove();
                        fetchNotifications(); 
                    });
                },
                error: function (err) {
                    console.error('Gagal menandai notifikasi sebagai terbaca:', err);
                }
            });
        });

    });
    </script> --}}

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
                success: function (response) {
                    $('#notification-list').empty();
                    const notifications = response.notifications;
                    const count = notifications.length;
                    $('#notification-count').text(count + ' reports');

                    const badge = $('#notif-badge');
                    if (count > 0) {
                        badge.text(count).removeClass('d-none');
                    } else {
                        badge.text('0').addClass('d-none');
                    }

                    if (count === 0) {
                        $('#notification-list').append(`
                            <div class="alert alert-info text-center" role="alert">
                                <i class="fas fa-info-circle me-2"></i> No notifications found
                            </div>
                        `);
                        $('#btn-see-all').addClass('d-none');
                        return;
                    }

                    // === Route Declarations ===
                    const approvalDetailRoute = @json(route('approvaldetail'));
                    const wocDetailApprovalRoute = @json(route('woc.detail.approval', ['encodedWO' => 'PLACEHOLDER']));
                    const approvalDetailMRRoute = @json(route('ApprovalDetailMR', ['encodedMRNo' => 'PLACEHOLDER']));
                    const caseDetailRoute = @json(route('case.detail', ['case_no' => 'PLACEHOLDER']));
                    const mrDetailRoute = @json(route('MaterialRequest.Detail', ['encodedMRNo' => 'PLACEHOLDER']));
                    const wocDetailRoute = @json(route('WocDetail', ['wo_no' => 'PLACEHOLDER']));

                    const maxVisible = 4;

                    notifications.forEach(function (notification, index) {
                        const rawRef = notification.reference_no;
                        const encodedRef = btoa(rawRef);
                        let detailUrl = '#';

                        if (notification.Notif_Type === 'BA' && userPermissions.includes('view cr_ap')) {
                            detailUrl = `${approvalDetailRoute}/${encodedRef}`;
                        } else if (notification.Notif_Type === 'WO' && userPermissions.includes('view cr_ap')) {
                            detailUrl = wocDetailApprovalRoute.replace('PLACEHOLDER', encodedRef);
                        } else if (notification.Notif_Type === 'MR' && userPermissions.includes('view mr_ap')) {
                            detailUrl = approvalDetailMRRoute.replace('PLACEHOLDER', encodedRef);
                        } else if (notification.Notif_Type === 'BA' && userPermissions.includes('view cr')) {
                            detailUrl = caseDetailRoute.replace('PLACEHOLDER', encodedRef);
                        } else if (notification.Notif_Type === 'MR' && userPermissions.includes('view mr')) {
                            detailUrl = mrDetailRoute.replace('PLACEHOLDER', encodedRef);
                        } else if (notification.Notif_Type === 'WO' && userPermissions.includes('view cr')) {
                            detailUrl = wocDetailRoute.replace('PLACEHOLDER', encodedRef);
                        }

                        const isHidden = index >= maxVisible ? 'style="display: none;"' : '';
                        const isRead = notification.Notif_IsRead === 'Y' ? 'bg-light' : '';

                        const notificationItem = `
                            <div class="d-flex justify-content-between align-items-start py-4 border-bottom notification-item ${isRead}"
                                ${isHidden}
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
                                    <button class="btn btn-icon btn-sm btn-light-success btn-mark-read"
                                            data-bs-toggle="tooltip"
                                            title="Mark as Read"
                                            data-id="${notification.Notif_No}">
                                        <i class="fas fa-check-circle text-success"></i>
                                    </button>
                                </div>
                            </div>
                        `;

                        $('#notification-list').append(notificationItem);
                    });

                    // Show/hide "See All" button
                    if (notifications.length > maxVisible) {
                        $('#btn-see-all').removeClass('d-none');
                    } else {
                        $('#btn-see-all').addClass('d-none');
                    }

                    // Reinitialize tooltips
                    $('[data-bs-toggle="tooltip"]').tooltip();
                },
                error: function (xhr, status, error) {
                    console.error('Gagal mengambil notifikasi:', error);
                }
            });
        }

        // Auto-load and refresh
        setInterval(fetchNotifications, 75000);
        fetchNotifications();

        // Klik notifikasi untuk redirect dan tandai sebagai terbaca
        $(document).on('click', '.notification-item', function () {
            const notifNo = $(this).data('notif-no');
            const detailUrl = $(this).data('detail-url');

            $.ajax({
                url: '{{ url("/notification/read") }}/' + notifNo,
                method: 'POST',
                success: function () {
                    window.location.href = detailUrl;
                },
                error: function () {
                    window.location.href = detailUrl;
                }
            });
        });

        // Klik tombol "Mark as Read"
        $(document).on('click', '.btn-mark-read', function (e) {
            e.stopPropagation();

            const notifNo = $(this).data('id');

            $.ajax({
                url: '{{ url("/notification/mark-as-read") }}/' + notifNo,
                method: 'POST',
                success: function () {
                    $(`.notification-item[data-notif-no="${notifNo}"]`).fadeOut(300, function () {
                        $(this).remove();
                        fetchNotifications();
                    });
                },
                error: function (err) {
                    console.error('Gagal menandai notifikasi sebagai terbaca:', err);
                }
            });
        });

        // Klik tombol "See All"
        $('#btn-see-all').on('click', function () {
            $('#notification-list .notification-item').slideDown();
            $(this).addClass('d-none');
        });
    });
</script>
