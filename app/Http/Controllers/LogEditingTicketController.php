<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpers\MakeResponse;
use Illuminate\Support\Facades\Validator;
use App\Models\LogEditingTicket;
use App\Http\Resources\LogEditingTicketCollection;

class LogEditingTicketController extends Controller
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
  

    /**
   * Validate the description field.
   *
   * @param  \Illuminate\Http\Request  $request
   */
    protected function validateData($request)
    {
        return Validator::make($request, [
      'ticket_id' => 'required',
      'user_id' => 'required'
    ]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            if (!request()->isJson()) {
                return $this->response->unauthorized();
            }

            $logEditingTicket = new LogEditingTicketCollection(LogEditingTicket::all());

            return $this->response->success($logEditingTicket);
        } catch (\Exception $exception) {
            return $this->response->exception($exception->getMessage());
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            if (!request()->isJson()) {
                return $this->response->unauthorized();
            }

            $validate = $this->validateData(request()->all());

            if ($validate->fails()) {
                return $this->response->exception($validate->errors());
            }

            $logEditingTicket = new LogEditingTicket();

            $logEditingTicket->ticket_id = $request->input('ticket_id');
            $logEditingTicket->user_id = $request->input('user_id');

            $logEditingTicket->save();

            return $this->response->created($logEditingTicket->format());
        } catch (\Exception $exception) {
            return $this->response->exception($exception->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($log_editing_ticket)
    {
        try {
            if (!request()->isJson()) {
                return $this->response->unauthorized();
            }

            if (!is_numeric($log_editing_ticket)) {
                return $this->response->badRequest();
            }

            $logEditingTicketModel = LogEditingTicket::find($log_editing_ticket);

            if (!isset($logEditingTicketModel)) {
                return $this->response->noContent();
            }

            return $this->response->success($logEditingTicketModel->format());
        } catch (\Exception $exception) {
            return $this->response->exception($exception->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($log_editing_ticket)
    {
        try {
            if (!request()->isJson()) {
                return $this->response->unauthorized();
            }

            if (!is_numeric($log_editing_ticket)) {
                return $this->response->badRequest();
            }

            $logEditingTicketModel = LogEditingTicket::find($log_editing_ticket);

            if (!isset($logEditingTicketModel)) {
                return $this->response->noContent();
            }

            $logEditingTicketModel->delete();

            return $this->response->success(null);
        } catch (\Exception $exception) {
            return $this->response->exception($exception->getMessage());
        }
    }

    public function findByTicket($ticket)
    {
        try {
            if (!request()->isJson()) {
                return $this->response->unauthorized();
            }

            if (!is_numeric($ticket)) {
                return $this->response->badRequest();
            }

            $logEditingTicketModel = LogEditingTicket::where('ticket_id', $ticket)->first();

            if (!isset($logEditingTicketModel)) {
                return $this->response->noContent();
            }

            return $this->response->success($logEditingTicketModel->format());
        } catch (\Exception $exception) {
            return $this->response->exception($exception->getMessage());
        }
    }
}
