<?php

namespace App\Http\Controllers;

use App\Helpers\MakeResponse;
use App\Models\Ticket;
use App\Http\Resources\Json\Ticket as JsonTicket;
use App\Http\Resources\Json\DetailTicket as JsonDetailTicket;
use App\Http\Resources\TicketCollection;
use Illuminate\Http\Request;

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

  protected function validateData()
  {
    return request()->validate([
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

      $dataStore = $this->validateData();

      $ticket = new Ticket();
      $ticket = $ticket->create($dataStore);

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
  public function show($id)
  {
    try {

      if (is_numeric($id)) {

        $ticket = Ticket::whereId($id)->first();

        if (isset($ticket)) {

          return response()->json([

            'success' => true,
            'ticket' => $ticket->format(),
            'error' => null
          ], 200);
        } else {

          return response()->json([

            'success' => false,
            'ticket' => null,
            'error' => 'No Content'
          ], 204);
        }
      } else {
        return response()->json([

          'success' => false,
          'ticket' => null,
          'error' => 'Bad Request'
        ], 400);
      }
    } catch (\Exception $exception) {

      return response()->json([
        'success' => false,
        'ticket' => null,
        'error' => $exception->getMessage()
      ], 500);
    }
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function update($id)
  {
    try {
      if (is_numeric($id)) {

        $ticket = Ticket::whereId($id)->first();

        if (isset($ticket)) {

          $dataUpdate = $this->validateData();

          $ticket->update($dataUpdate);

          return response()->json([
            'success' => true,
            'ticket' => $ticket->format(),
            'error' => null
          ], 200);
        } else {

          return response()->json([
            'success' => false,
            'ticket' => null,
            'error' => 'No Content'
          ], 204);
        }
      } else {

        return response()->json([
          'success' => false,
          'ticket' => null,
          'error' => 'Bad Request'
        ], 400);
      }
    } catch (\Exception $exception) {

      return response()->json([
        'success' => false,
        'ticket' => null,
        'error' => $exception->getMessage()
      ], 500);
    }
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function destroy($id)
  {
    try {

      if (is_numeric($id)) {
        $ticket = Ticket::whereId($id)->first();

        if (isset($ticket)) {
          return response()->json([

            'success' => true,
            'ticket' => null,
            'error' => null
          ], 200);
        } else {
          return response()->json([

            'success' => false,
            'ticket' => null,
            'error' => 'No Content'
          ], 204);
        }
      } else {
        return response()->json([

          'success' => false,
          'ticket' => null,
          'error' => 'Bad Request'
        ], 400);
      }
    } catch (\Exception $exception) {

      return response()->json([
        'success' => false,
        'ticket' => null,
        'error' => $exception->getMessage()
      ], 500);
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
              return new JsonDetailTicket($ticketDetail);
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
