<?php

namespace App\Http\Controllers;

use App\Helpers\MakeResponse;
use App\Models\Ticket;
use App\Http\Resources\Json\Ticket as JsonTicket;
use App\Http\Resources\Json\TicketDetail as JsonTicketDetail;
use App\Http\Resources\TicketCollection;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TicketController extends Controller
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
      'course_registered_user_id' => 'required|integer',
      'type_ticket_id' => 'required|integer',
      'status_ticket_id' => 'required|integer',
      'source_ticket_id' => 'required|integer',
      'priority_ticket_id' => 'required|integer',
      'motive_ticket_id' => 'required|integer',
      'user_create_id' => 'required|integer',
      'user_assigned_id' => 'required|integer',
      'closing_date' => 'date',
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

      if (!request()->isJson())
        return $this->response->unauthorized();

      $tickets = new TicketCollection(Ticket::orderBy('created_at', 'asc')->get());

      return $this->response->success($tickets);
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
  public function store()
  {
    try {

      if (!request()->isJson())
        return $this->response->unauthorized();

      $validate = $this->validateData(request()->all());

      if ($validate->fails())
        return $this->response->exception($validate->errors());


      $ticket = new Ticket();


      $ticket->course_registered_user_id = request()->course_registered_user_id;
      $ticket->type_ticket_id = request()->type_ticket_id;
      $ticket->status_ticket_id = request()->status_ticket_id;
      $ticket->source_ticket_id = request()->source_ticket_id;
      $ticket->priority_ticket_id = request()->priority_ticket_id;
      $ticket->motive_ticket_id = request()->motive_ticket_id;
      $ticket->user_create_id = auth()->id();
      $ticket->user_assigned_id = request()->user_assigned_id;


      if (isset(request()->closing_date)) {
        $ticket->closing_date = Carbon::now()->format('Y-m-d H:i:s');
      }

      $ticket->save();

      return $this->response->success($ticket->fresh()->format());
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
  public function show($ticket)
  {

    try {

      if (!request()->isJson())
        return $this->response->unauthorized();

      if (!is_numeric($ticket))
        return $this->response->badRequest();

      $ticketModel = Ticket::find($ticket);

      if (!isset($ticketModel))
        return $this->response->noContent();

      return $this->response->success($ticketModel->format());
    } catch (\Exception $exception) {

      return $this->response->exception($exception->getMessage());
    }
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function update($ticket)
  {
    try {

      if (!request()->isJson())
        return $this->response->unauthorized();

      if (!is_numeric($ticket))
        return $this->response->badRequest();

      $ticketModel = Ticket::find($ticket);

      if (!isset($ticketModel))
        return $this->response->noContent();

      $validate = $this->validateData(request()->all());

      if ($validate->fails())
        return $this->response->exception($validate->errors());

      $ticketModel->course_registered_user_id = request()->course_registered_user_id;
      $ticketModel->type_ticket_id = request()->type_ticket_id;
      $ticketModel->status_ticket_id = request()->status_ticket_id;
      $ticketModel->source_ticket_id = request()->source_ticket_id;
      $ticketModel->priority_ticket_id = request()->priority_ticket_id;
      $ticketModel->motive_ticket_id = request()->motive_ticket_id;
      $ticketModel->user_create_id = auth()->id();
      $ticketModel->user_assigned_id = request()->user_assigned_id;

      if (isset(request()->closing_date)) {
        $ticketModel->closing_date = Carbon::now()->format('Y-m-d H:m:s');
      }

      $ticketModel->save();

      return $this->response->success($ticketModel->fresh()->format());
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
  public function destroy($ticket)
  {
    try {

      if (!request()->isJson())
        return $this->response->unauthorized();

      if (!is_numeric($ticket))
        return $this->response->badRequest();

      $ticketModel = Ticket::find($ticket);

      if (!isset($ticketModel))
        return $this->response->noContent();

      $ticketModel->delete();

      return $this->response->success(null);
    } catch (\Exception $exception) {

      return $this->response->exception($exception->getMessage());
    }
  }


  /**
   * Display a list of tickets resources related to type ticket resource.
   *
   * @param  int  $type_ticket
   * @return App\Helpers\MakeResponse
   * 
   * @authenticated 
   * @response {
   *  "typeTicket": "typeTicket",
   *  "relationships":{
   *    "links": {"href": "url", "rel": "/rels/tickets"},
   *    "collections": {"numberOfElements": "number", "data": "array"}
   *   }
   * }
   * 
   * @urlParam type_ticket required The ID of the type ticket resource.
   */
  public function ticketsDetails($ticket)
  {
    try {
      if (!request()->isJson())
        return $this->response->unauthorized();

      if (!is_numeric($ticket))
        return $this->response->badRequest();

      $ticketModel = Ticket::find($ticket);


      if (!isset($ticketModel))
        return $this->response->noContent();

      $ticketFormated = new JsonTicket($ticketModel);

      $ticketFormated->ticketsDetails = [
        'ticket' => $ticketFormated,
        'relationships' => [
          'links' => [
            'href' => route(
              'api.tickets.ticketsDetails',
              ['ticket' => $ticketFormated->id],
              false
            ),
            'rel' => '/rels/ticketsDetails'
          ],
          'collection' => [
            'numberOfElements' => $ticketFormated->ticketsDetails->count(),
            'data' => $ticketFormated->ticketsDetails->map(function ($ticketDetail) {
              return new JsonTicketDetail($ticketDetail);
            })
          ]
        ]
      ];

      return $this->response->success($ticketFormated->ticketsDetails);
    } catch (\Exception $exception) {

      return $this->response->exception($exception->getMessage());
    }
  }
}
