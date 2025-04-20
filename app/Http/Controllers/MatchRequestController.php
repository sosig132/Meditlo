<?php
namespace App\Http\Controllers;

use App\Models\MatchRequest;
use App\Models\User;
use App\Notifications\MatchRequestNotification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class MatchRequestController extends Controller
{
    public function create(Request $request, $receiverId)
    {
        $sender = Auth::user();
        $receiver = User::findOrFail($receiverId);

        $matchRequest = MatchRequest::create([
            'sender_id' => $sender->id,
            'receiver_id' => $receiver->id,
            'status' => 'pending',
        ]);

        $receiver->notify(new MatchRequestNotification($matchRequest));

        return redirect()->back()->with('message', 'Match request sent!');
    }

    public function accept(Request $request, $id)
    {
        $matchRequest = MatchRequest::findOrFail($id);
        $matchRequest->markAsAccepted();

        return redirect()->back()->with('message', 'Match request accepted!');
    }
    public function reject(Request $request, $id)
    {
        $matchRequest = MatchRequest::findOrFail($id);
        $matchRequest->markAsRejected();

        return redirect()->back()->with('message', 'Match request rejected!');
    }
}

