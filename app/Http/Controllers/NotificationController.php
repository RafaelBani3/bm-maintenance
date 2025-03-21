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
                                     ->get();
    
        return response()->json([
            'notifications' => $notifications,
        ]);
    }




    
}