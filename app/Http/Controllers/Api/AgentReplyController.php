<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Ticket;
use App\Models\Reply;

class AgentReplyController extends Controller
{
    public function reply(Request $request, $ticketId)
    {
        $request->validate([
            'message' => 'required|string'
        ]);

        $ticket = Ticket::findOrFail($ticketId);

        // get logged-in user via Sanctum
        $user = $request->user();

        

        // only assigned agent can reply
        if ($ticket->assigned_to != $user->id) {
            return response()->json([
                'message' => 'You are not assigned to this ticket'
            ], 403);
        }

        Reply::create([
            'ticket_id' => $ticket->id,
            'user_id' => $user->id,
            'message' => $request->message
        ]);

        $ticket->status = 'answered';
        $ticket->save();

        return response()->json([
            'success' => true,
            'message' => 'Reply sent successfully'
        ]);
    }
}