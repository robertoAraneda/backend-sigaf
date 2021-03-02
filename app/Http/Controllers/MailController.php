<?php

namespace App\Http\Controllers;

use App\Models\Ticket as ModelTicket;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;


use Illuminate\Http\Request;

class MailController extends Controller
{
    public function sendMassive(Request $request)
    {
        try {
            $ticketsId = \json_decode($request->ticketsId);
        } catch (\Throwable $th) {
            $ticketsId = $request->ticketsId;
        }
   

        $files = [];

        $upload_path = storage_path('app');

        if ($request->files) {
            foreach ($request->files as $key => $value) {
                $file_name = $value->getClientOriginalName();
                $generated_new_name = $key. '.'.$value->getClientOriginalExtension();
                $value->move($upload_path, $generated_new_name);
                $files[] =['nameStore' => $generated_new_name, 'originalName' =>  $file_name, 'mime' => $value->getClientMimeType()] ;
            }
        }
     
        foreach ($ticketsId  as $key => $value) {
            $ticket = ModelTicket::where('id', $value)->with(['courseRegisteredUser.course', 'courseRegisteredUser.registeredUser'])->first();
            $details['title']   = "SIGAF";
            $details['subject'] = $request->subject;
            $details['body']    = $request->text;
            $details['files']   = $files;
            $details['course']  = $ticket->courseRegisteredUser->course->description;
            $details['fullname']=  "{$ticket->courseRegisteredUser->registeredUser->name}
                                    {$ticket->courseRegisteredUser->registeredUser->last_name} 
                                    {$ticket->courseRegisteredUser->registeredUser->mother_last_name}";
            dispatch(new \App\Jobs\ProcessMailTicket($details));
        }
    }
}
