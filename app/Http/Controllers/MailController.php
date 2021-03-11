<?php

namespace App\Http\Controllers;

use App\Models\Ticket as ModelTicket;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use App\Helpers\MakeResponse;


use Illuminate\Http\Request;

class MailController extends Controller
{

      /**
   * Property for make a response.
   *
   * @var  App\Helpers\MakeResponse  $response
   */
    protected $response;

    public function __construct(MakeResponse $makeResponse = null)
    {
        $this->response = $makeResponse;
    }


    public function sendMassive(Request $request)
    {
        try {
            if (!request()->isJson()) {
                return $this->response->unauthorized();
            }

            try {
                $ticketsId = \json_decode($request->ticketsId);
            } catch (\Throwable $th) {
                $ticketsId = $request->ticketsId;
            }

            $files = [];

            $upload_path = storage_path('app');

            if ($request->files) {
                foreach ($request->input('files') as $key => $value) {
                    $file_name = $value['name'];
                    $file_mime = $value['mime'];
                    $files[] =['nameStore' => $file_name, 'originalName' =>  $file_name, 'mime' => $file_mime] ;
                }
            }

            $mailsSend = [];
     
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
                $mailsSend[]= $details;

                dispatch(new \App\Jobs\ProcessMailTicket($details));
            }

            return $this->response->success($mailsSend);
        } catch (\Exception $exception) {
            return $this->response->exception($exception->getMessage());
        }
    }

    public function sendSingle(Request $request)
    {
        try {
            $ticketId = $request->ticketId;

            $files = [];

            $upload_path = storage_path('app');

            if ($request->files) {
                foreach ($request->input('files') as $key => $value) {
                    $file_name = $value['name'];
                    $file_mime = $value['mime'];
                    $files[] =['nameStore' => $file_name, 'originalName' =>  $file_name, 'mime' => $file_mime] ;
                }
            }
     
            $ticket = ModelTicket::where('id', $ticketId)->with(['courseRegisteredUser.course', 'courseRegisteredUser.registeredUser'])->first();
            $details['title']   = "SIGAF";
            $details['subject'] = $request->subject;
            $details['body']    = $request->text;
            $details['files']   = $files;
            $details['course']  = $ticket->courseRegisteredUser->course->description;
            $details['fullname']=  "{$ticket->courseRegisteredUser->registeredUser->name}
                                    {$ticket->courseRegisteredUser->registeredUser->last_name} 
                                    {$ticket->courseRegisteredUser->registeredUser->mother_last_name}";

            dispatch(new \App\Jobs\ProcessMailTicket($details));
  
            return $this->response->success($details);
        } catch (\Throwable $exception) {
            return $this->response->exception($exception->getMessage());
        }
    }

    public function sendSingle_(Request $request)
    {
        try {
            $ticketId = $request->ticketId;

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
     
            $ticket = ModelTicket::where('id', $ticketId)->with(['courseRegisteredUser.course', 'courseRegisteredUser.registeredUser'])->first();
            $details['title']   = "SIGAF";
            $details['subject'] = $request->subject;
            $details['body']    = $request->text;
            $details['files']   = $files;
            $details['course']  = $ticket->courseRegisteredUser->course->description;
            $details['fullname']=  "{$ticket->courseRegisteredUser->registeredUser->name}
                                    {$ticket->courseRegisteredUser->registeredUser->last_name} 
                                    {$ticket->courseRegisteredUser->registeredUser->mother_last_name}";

            dispatch(new \App\Jobs\ProcessMailTicket($details));
  
            return $this->response->success($details);
        } catch (\Throwable $exception) {
            return $this->response->exception($exception->getMessage());
        }
    }
}
