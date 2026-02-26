<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Ticket;
use App\Models\User;

class AdminTicketController extends Controller
{
    public function assign(Request $request, $ticketId)
    {
        if (!$request->user()->isAdmin()) {
            return response()->json(['message'=>'Unauthorized'],403);
        }

        $request->validate([
            'agent_id' => 'required|exists:users,id'
        ]);

        $agent = User::find($request->agent_id);

        if (!$agent->isAgent()) {
            return response()->json(['message'=>'User is not an agent'],422);
        }

        $ticket = Ticket::findOrFail($ticketId);
        $ticket->assigned_to = $agent->id;
        $ticket->status = 'pending';
        $ticket->save();

        return response()->json([
            'success'=>true,
            'message'=>'Ticket assigned to agent'
        ]);
    }
}