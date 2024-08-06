<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\Ticket;
use App\Models\TicketMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class TicketController extends Controller
{
    public function index()
    {
        return view('Panel.ticket.index');
    }

    public function ticketChat(Request $request, $ticket_id)
    {
        $ticket = Ticket::find($ticket_id);
        if (!$ticket)
            abort(404);
        if ($ticket->user_id != $request->user()->id)
            abort(404);
        $ticket_messages = $ticket->messages()->simplePaginate(10);
        return view('panel.ticket.ticketChat', compact('ticket','ticket_messages'));
    }

    public function ticketClientMessage(Request $request)
    {
        $ticket = Ticket::find($request->ticket_id);
        if (!$ticket)
            abort(404);
        if ($ticket->user_id != $request->user()->id)
            abort(404);
        $new_ticket = TicketMessage::create([
            'ticket_id' => $ticket->id,
            'user_id' =>  $ticket->user_id,
            'message' => $request->message
        ]);
        return [
            'success' => true,
            'data' => $new_ticket
        ];
    }

}
