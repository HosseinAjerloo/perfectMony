<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Ticket\TicketRequest;
use App\Models\Ticket;
use App\Models\TicketMessage;
use App\Services\ImageService\ImageService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Morilog\Jalali\Jalalian;

class TicketController extends Controller
{
    public function index(Request $request)
    {
        $tickets = Ticket::orderBy('id', 'desc')->simplePaginate(10);
        return view('Admin.Ticket.tickets', compact('tickets'));
    }

    public function ticketPage(Request $request)
    {
        $tickets = Ticket::orderBy('id', 'desc')->simplePaginate(10);
        foreach ($tickets as $ticket) {
            $ticket->date = \Morilog\Jalali\Jalalian::forge($ticket->created_at)->format('Y/m/d H:i:s');
            $ticket->status = $ticket->ticketStatus();
            $ticket->route = route('panel.admin.ticket-chat', $ticket->id);
            if ($ticket->user->type != 'admin') {
                $ticket->loginAnotherUser = route('panel.admin.login-another-user', $ticket->user_id);
            }
            $ticket->userName=$ticket->user->fullName??'-';
            $ticket->changeStaus=route('panel.admin.tickets.close',$ticket->id);

        }
        return [
            'success' => true,
            'data' => $tickets,
            'has_more' => $tickets->hasMorePages()
        ];
    }

    public function ticketChat(Request $request, $ticket_id)
    {
        $ticket = Ticket::find($ticket_id);
        if (!$ticket)
            abort(404);
        $ticket_messages = TicketMessage::where('ticket_id', $ticket_id)->get();
        return view('Admin.Ticket.ticketChat', compact('ticket', 'ticket_messages'));
    }

    public function ticketMessage(TicketRequest $request, ImageService $imageService)
    {

        $user = Auth::user();
        $ticket = Ticket::find($request->ticket_id);
        if (!$ticket)
            abort(404);
        $inputs = $request->all();
        $ticket->update(['status' => 'has_been_answered']);
        $inputs['ticket_id'] = $ticket->id;
        $inputs['admin_id'] = $user->id;
        if ($request->hasFile('image')) {
            $imageService->setFileFolder('ticket');
            $imageService->saveImage($request->file('image'));
            $inputs['type'] = 'file';
            $new_ticket = TicketMessage::create($inputs);
            $result = $new_ticket->image()->create(['user_id' => $user->id, 'path' => $imageService->getFinalFileAddres()]);
            $result->jalali_date = Jalalian::fromCarbon($result->created_at)->format('h:i Y/m/d');
            $result->value = route('panel.ticket.download', $result->id);
            $result->crs = asset($result->path);
            return $result ? response()->json(['success' => true, 'data' => $result]) : response()->json(['success' => false]);
        } else {

            $inputs['type'] = 'message';
            $new_ticket = TicketMessage::create($inputs);

            $new_ticket->jalali_date = Jalalian::fromCarbon($new_ticket->created_at)->format('h:i Y/m/d');
            return [
                'success' => true,
                'data' => $new_ticket
            ];
        }
    }

    public function closeTicket(Ticket $ticket)
    {
        $inputs['status'] = 'closed';
        $ticketMessage = $ticket->messages()->latest()->first();
        if ($ticket->status == 'closed') {
            $inputs['status'] = isset($ticketMessage->admin_id) ? 'has_been_answered' : 'waiting_for_an_answer';
        }
        $ticket->update($inputs);
        return redirect()->route('panel.admin.tickets')->with('success', 'وضعیت تیکت بروز رسانی شد');
    }

}
