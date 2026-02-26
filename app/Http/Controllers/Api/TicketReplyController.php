<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Ticket;
use App\Models\TicketReply;

class TicketReplyController extends Controller
{
    // Add reply
    public function reply(Request $request, $ticketId)
    {
        $request->validate([
            'message' => 'required|string'
        ]);

        $ticket = Ticket::findOrFail($ticketId);

        $reply = TicketReply::create([
            'ticket_id' => $ticket->id,
            'user_id' => $request->user()->id,
            'message' => $request->message
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Reply added',
            'data' => $reply
        ]);
    }

    // View conversation
    public function conversation($ticketId)
    {
        $ticket = Ticket::with(['replies.user'])->findOrFail($ticketId);

        return response()->json($ticket);
    }
}