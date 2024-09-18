<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Http\Requests\Panel\Ticket\AddTicketSubmitRequest;
use App\Http\Requests\Panel\Ticket\TicketRequest;
use App\Models\File;
use App\Models\Ticket;
use App\Models\TicketMessage;
use App\Models\User;
use App\Services\ImageService\ImageService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File as FileAlias;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Str;
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

    public function ticketMessage(TicketRequest $request, ImageService $imageService)
    {
        $user = Auth::user();
        $ticket = Ticket::find($request->ticket_id);
        $ticket->update(['status'=>'waiting_for_an_answer']);

        if (!$ticket)
            abort(404);
        $inputs = $request->all();
        $inputs['ticket_id'] = $ticket->id;
        $inputs['user_id'] = $ticket->user_id;
        if ($request->hasFile('image')) {
            $imageService->setFileFolder('ticket');
            $imageService->saveImage($request->file('image'));
            $inputs['type'] = 'file';
            $new_ticket = TicketMessage::create($inputs);
            $result = $new_ticket->image()->create(['user_id' => $ticket->user_id, 'path' => $imageService->getFinalFileAddres()]);
            $result->jalali_date=Jalalian::fromCarbon($result->created_at)->format('h:i Y/m/d');
            $result->value=route('panel.ticket.download',$result->id);
            $result->crs=asset($result->path);
            return $result ? response()->json(['success' => true,'data'=>$result]) : response()->json(['success' => false]);
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

    public function ticketAddSubmit(AddTicketSubmitRequest $request,ImageService $imageService)
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

        if ($request->hasFile('image')) {
            $imageService->setFileFolder('ticket');
            $imageService->saveImage($request->file('image'));
            $inputs['ticket_id'] = $ticket->id;
            $inputs['user_id'] = $ticket->user_id;
            $inputs['type'] = 'file';
            $new_ticket = TicketMessage::create($inputs);
            $result = $new_ticket->image()->create(['user_id' => $ticket->user_id, 'path' => $imageService->getFinalFileAddres()]);
        }
        return redirect()->route('panel.ticket')->with(['success' => "تیکت با موفقیت ثبت شد."]);
    }
    public function download(Request $request,File $file)
    {
            $path=public_path($file->path);
            return FileAlias::exists($path)?Response::download($path):  redirect()->back()->withErrors(['error' => 'دانلود فایل با خطا مواجه شد لطفا بعدا تلاش فرمایید']);
    }
}
