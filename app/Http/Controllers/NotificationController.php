<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class NotificationController extends Controller
{
    public function fetchNotifications()
    {
        $notifications = Notification::where('Notif_To', Auth::id()) 
                                    ->orderBy('Notif_Date', 'desc')
                                    ->take(10)
                                    ->select('Notif_No', 'Notif_Title', 'Notif_Text', 'Notif_Type', 'Notif_Date', 'reference_no')
                                    ->get();

        Log::info("Fetched Notifs:", $notifications->toArray());

        return response()->json([
            'notifications' => $notifications,
        ]);
    }

    public function markAsRead($id)
    {
        Log::info("Mark as read attempt for Notif_No: " . $id . ", by user ID: " . Auth::id());

        try {
            $notification = Notification::where('Notif_No', $id)
                                        ->where('Notif_To', Auth::id())
                                        ->first();

            if ($notification) {
                $notification->Notif_IsRead = 'Y';
                $notification->save();

                Log::info("Notification marked as read. Notif_No: " . $id);

                return response()->json(['status' => 'success']);
            } else {
                Log::error("Notification not found or unauthorized access. Notif_No: " . $id);
                return response()->json(['status' => 'not_found'], 404);
            }
        } catch (\Exception $e) {
            Log::error("Error marking notification as read: " . $e->getMessage());
            return response()->json(['status' => 'error', 'message' => 'Internal Server Error'], 500);
        }
    }





    
}