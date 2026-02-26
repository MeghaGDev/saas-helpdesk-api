<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Ticket;

class TicketConversationController extends Controller
{
    public function show($id)
    {
        $ticket = Ticket::with([
            'customer',
            'agent',
            'replies.user'
        ])->findOrFail($id);

        return response()->json([
            'ticket' => [
                'id' => $ticket->id,
                'title' => $ticket->title,
                'status' => $ticket->status,
                'created_at' => $ticket->created_at->format('d M Y h:i A'),
            ],

            'customer' => [
                'id' => $ticket->customer->id,
                'name' => $ticket->customer->name,
                'email' => $ticket->customer->email,
            ],

            'assigned_agent' => $ticket->agent ? [
                'id' => $ticket->agent->id,
                'name' => $ticket->agent->name,
                'email' => $ticket->agent->email,
            ] : null,

            'conversation' => $ticket->replies->map(function ($reply) {
                return [
                    'reply_id' => $reply->id,
                    'message' => $reply->message,
                    'role' => $reply->sender_type,
                    'replied_by' => $reply->user->name,
                    'time' => $reply->created_at->format('d M Y h:i A'),
                ];
            })
        ]);
    }
}