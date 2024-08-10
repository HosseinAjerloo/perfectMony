<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\Ticket;
use App\Models\TicketMessage;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Morilog\Jalali\Jalalian;


class TicketController extends Controller
{
    public function index()
    {
        $tickets = Ticket::orderBy('id', 'desc')->where('user_id', \request()->user()->id)->simplePaginate(10);
        return view('Panel.Ticket.tickets', compact('tickets'));
    }

    public function ticketChat(Request $request, Ticket $ticket)
    {
        $user = Auth::user();
        $ticket = $ticket->where('user_id', $user->id)->where('id', $ticket->id)->first();
        if (!$ticket)
            abort(404);
        $ticket_messages = $ticket->messages;
        return view('panel.ticket.ticketChat', compact('ticket', 'ticket_messages'));
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
            'user_id' => $ticket->user_id,
            'message' => $request->message
        ]);
        $new_ticket->jalali_date = Jalalian::fromCarbon($new_ticket->created_at)->format('h:i Y/m/d');
        return [
            'success' => true,
            'data' => $new_ticket
        ];
    }

    public function ticketAddSubmit(Request $request)
    {
        $ticket = Ticket::create([
            'user_id' => $request->user()->id,
            'subject' => $request->subject,
            'status' => 'waiting_for_an_answer'
        ]);
        TicketMessage::create([
            'ticket_id' => $ticket->id,
            'user_id' => $request->user()->id,
            'message' => $request->message
        ]);
        return redirect()->route('panel.ticket')->with(['success' => "تیکت با موفقیت ثبت شد."]);
    }
}
