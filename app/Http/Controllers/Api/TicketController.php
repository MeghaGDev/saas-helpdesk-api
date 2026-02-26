<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Ticket;

class TicketController extends Controller
{
    // Create Ticket
    public function store(Request $request)
    {
        $request->validate([
            'subject' => 'required|string',
            'description' => 'required|string',
            'priority' => 'in:low,medium,high'
        ]);

        $ticket = Ticket::create([
            'user_id' => $request->user()->id,
            'subject' => $request->subject,
            'description' => $request->description,
            'priority' => $request->priority ?? 'medium'
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Ticket created',
            'ticket' => $ticket
        ]);
    }

    // List My Tickets
    public function myTickets(Request $request)
    {
        $tickets = Ticket::where('user_id', $request->user()->id)
                    ->latest()
                    ->get();

        return response()->json($tickets);
    }
}