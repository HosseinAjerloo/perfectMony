<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ticket;
use App\Models\TicketMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Morilog\Jalali\Jalalian;

class TicketController extends Controller
{
    public function index(Request $request)
    {
        $tickets = Ticket::orderBy('id', 'desc')->simplePaginate(10);
        return view('Admin.Ticket.tickets',compact('tickets'));
    }
    public function ticketPage(Request $request)
    {
        $tickets = Ticket::orderBy('id', 'desc')->simplePaginate(10);
        foreach ($tickets as $ticket){
            $ticket->date = \Morilog\Jalali\Jalalian::forge($ticket->created_at)->format('Y/m/d H:i:s');
            $ticket->status = $ticket->ticketStatus();
        }
        return [
            'success' => true,
            'data' => $tickets,
            'has_more' => $tickets->hasMorePages()
        ];
    }

    public function ticketChat(Request $request,$ticket_id)
    {
        $ticket = Ticket::find($ticket_id);
        if (!$ticket)
            abort(404);
        $ticket_messages = TicketMessage::where('ticket_id',$ticket_id)->get();
        return view('Admin.Ticket.TicketChat', compact('ticket', 'ticket_messages'));
    }
    public function ticketMessage(Request $request)
    {
        $ticket = Ticket::find($request->ticket_id);
        if (!$ticket)
            abort(404);
        $new_ticket = TicketMessage::create([
            'ticket_id' => $ticket->id,
            'admin_id' =>  $request->user()->id,
            'message' => $request->message
        ]);
        $new_ticket->jalali_date = Jalalian::fromCarbon($new_ticket->created_at)->format('h:i Y/m/d');
        return [
            'success' => true,
            'data' => $new_ticket
        ];
    }
}
