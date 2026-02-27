<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Ticket;
use App\Models\Reply;
use Illuminate\Support\Facades\Mail;
use App\Mail\TicketReplyMail;

class AgentReplyController extends Controller
{
    /* public function reply(Request $request, $ticketId)
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

     $reply=   Reply::create([
            'ticket_id' => $ticket->id,
            'user_id' => $user->id,
            'message' => $request->message
        ]);

        $ticket->status = 'answered';
        $ticket->save();

  

        // 🔥 Send Email to Customer
        Mail::to($ticket->customer->email)
            ->send(new TicketReplyMail($ticket, $reply));

        return response()->json([
            'success' => true,
            'message' => 'Reply sent successfully'
        ]);
    } */

    public function reply(Request $request, $ticketId)
    {
        $request->validate([
            'message' => 'required|string'
        ]);

        $ticket = Ticket::findOrFail($ticketId);
        $user = $request->user();

        // Only assigned agent can reply
        if ($ticket->assigned_to != $user->id) {
            return response()->json([
                'message' => 'You are not assigned to this ticket'
            ], 403);
        }

        // Save reply
        $reply = Reply::create([
            'ticket_id' => $ticket->id,
            'user_id' => $user->id,
            'message' => $request->message
        ]);

        // Update ticket status
        $ticket->status = 'answered';
        $ticket->save();

        // Send Email
        Mail::to($ticket->customer->email)
            ->send(new TicketReplyMail($ticket, $reply));

        return response()->json([
            'success' => true,
            'message' => 'Reply sent successfully'
        ]);
    }
}
