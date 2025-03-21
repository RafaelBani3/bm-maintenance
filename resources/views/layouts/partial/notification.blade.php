<div class="menu menu-sub menu-sub-dropdown menu-column w-350px w-lg-375px" data-kt-menu="true" id="kt_menu_notifications" style="position: relative;">
    <div class="d-flex flex-column bgi-no-repeat rounded-top" style="background-image:url({{ asset('assets/media/misc/menu-header-bg.jpg') }})">
        <h3 class="text-white fw-semibold px-9 mt-10 mb-6">Notifications 
        <span class="fs-8 opacity-75 ps-3" id="notification-count">0 reports</span></h3>

        <ul class="nav nav-line-tabs nav-line-tabs-2x nav-stretch fw-semibold px-9">
            <li class="nav-item">
                <a class="nav-link text-white opacity-75 opacity-state-100 pb-4" data-bs-toggle="tab" href="#kt_topbar_notifications_1">Alerts</a>
            </li>
        </ul>
    </div>

    <div class="tab-content">
        <div class="tab-pane fade" id="kt_topbar_notifications_1" role="tabpanel">
            <div class="scroll-y mh-325px my-5 px-8" id="notification-list">

            </div>       
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    function fetchNotifications() {
        $.ajax({
            url: '{{ route('Notifications') }}',  
            method: 'GET',
            success: function(response) {             
                // Clear existing notifications
                $('#notification-list').empty();

                $('#notification-list').empty();
                $('#notification-count').text(response.notifications.length + ' reports');

                // Append new notifications
                response.notifications.forEach(function(notification) {
                    var notificationItem = `
                            <div class="d-flex flex-stack py-4 notification-item" style="cursor: pointer;" onclick="markAsRead(${notification.id})">

                            <div class="d-flex align-items-center">
                                <div class="symbol symbol-35px me-4">
                                    <span class="symbol-label bg-light-primary">
                                        <i class="ki-duotone ki-abstract-28 fs-2 text-primary"></i>
                                    </span>
                                </div>
                                <div class="mb-0 me-2">
                                    <a href="#" class="fs-6 text-gray-800 text-hover-primary fw-bold">${notification.Notif_Title}</a>
                                    <div class="text-gray-500 fs-7">${notification.Notif_Text}</div>
                                </div>
                            </div>
                            <span class="badge badge-light fs-8">${notification.Notif_Date}</span>
                            <button class="btn btn-danger btn-sm" onclick="dismissNotification(${notification.id})">Dismiss</button>

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

    // Fetch notifications every 5 seconds (or adjust interval as needed)
    setInterval(fetchNotifications, 5000);

    // Initial call to fetch notifications when the page loads
    fetchNotifications();
</script>
