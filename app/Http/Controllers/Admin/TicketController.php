<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ticket;
use App\Models\TicketMessage;
use Illuminate\Http\Request;
use Morilog\Jalali\Jalalian;

class TicketController extends Controller
{
    public function index()
    {
        $tickets = Ticket::orderBy('id', 'desc')->where('user_id',\request()->user()->id)->simplePaginate(10);
        return view('Panel.Ticket.tickets',compact('tickets'));
    }
    public function ticketMessage(Request $request)
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
        $new_ticket->jalali_date = Jalalian::fromCarbon($new_ticket->created_at)->format('h:i Y/m/d');
        return [
            'success' => true,
            'data' => $new_ticket
        ];
    }

}
