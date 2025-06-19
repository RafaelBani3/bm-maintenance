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
                                    ->where('Notif_IsRead', 'N')
                                    ->orderBy('Notif_Date', 'desc')
                                    ->take(10)
                                    ->select('Notif_No', 'Notif_Title', 'Notif_Text', 'Notif_Type', 'Notif_Date', 'reference_no')
                                    ->get();

        Log::info("Fetched Notifs:", $notifications->toArray());

        return response()->json([
            'notifications' => $notifications,
        ]);
    }

// NotificationController.php
    public function markAsRead($id)
    {
        $notification = Notification::where('Notif_No', $id)
                                    ->where('Notif_To', Auth::id())
                                    ->first();

        if ($notification) {
            $notification->Notif_IsRead = 'Y';
            $notification->save();
            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false], 404);
    }

    public function ButtonMarkAsRead($notifNo)
    {
        $notif = Notification::where('Notif_No', $notifNo)->first();

        if (!$notif) {
            return response()->json(['error' => 'Notification not found'], 404);
        }

        $notif->Notif_IsRead = 'Y';
        $notif->save();

        return response()->json(['message' => 'Notification marked as read']);
    }






    
}