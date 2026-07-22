<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Notification;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = Notification::where('user_id', auth()->id())
            ->latest()
            ->get();

        // Marquer toutes comme lues
        Notification::where('user_id', auth()->id())
            ->where('lu', false)
            ->update(['lu' => true]);

        return view('notifications', compact('notifications'));
    }

    public function marquerLu(Notification $notification)
    {
        if ($notification->user_id !== auth()->id()) abort(403);
        $notification->update(['lu' => true]);
        return back();
    }

    public function supprimerTout()
    {
        Notification::where('user_id', auth()->id())->delete();
        return back()->with('success', 'Toutes les notifications supprimées.');
    }

    public function count()
    {
        return response()->json([
            'count' => Notification::where('user_id', auth()->id())
                ->where('lu', false)
                ->count()
        ]);
    }
}