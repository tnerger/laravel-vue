<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Support\Facades\Gate;
use Inertia\Response;



class NotificationController extends Controller
{
    public function index(Request $request): Response
    {
        return inertia(
            'Notification/Index',
            [
                'notifications' => $request->user()->notifications()->paginate(10)
            ]
        );
    }

    public function read(Request $request, DatabaseNotification $notification)
    {

        Gate::authorize('update', [$notification]);
        $notification->markAsRead();
        return redirect()->back()
            ->with('succeess', 'Notification is marked as read.')
        ;
    }
}
