<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Http\Requests\Panel\Ticket\TicketRequest;
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
        return view('Panel.Ticket.ticketChat', compact('ticket', 'ticket_messages'));
    }

    public function ticketMessage(TicketRequest $request)
    {
        $user=Auth::user();
        $ticket = Ticket::where('user_id',$user->id)->where('id',$request->ticket_id)->first();
        if (!$ticket)
            abort(404);
        $inputs=$request->all();
        dd($inputs);
        if ($request->hasFile('image'))
        {
            $inputs['type']='file';
        }
        else{
            $inputs['ticket_id']=$ticket->id;
            $inputs['user_id']=$ticket->user_id;
        }
        $new_ticket = TicketMessage::create([


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
