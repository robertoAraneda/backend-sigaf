<?php

namespace App\Http\Controllers;

use App\Helpers\MakeResponse;
use App\Http\Resources\Json\PriorityTicket as JsonPriorityTicket;
use App\Http\Resources\Json\Ticket as JsonTicket;
use App\Http\Resources\PriorityTicketCollection;
use App\Models\PriorityTicket;
use Illuminate\Support\Facades\Validator;

class PriorityTicketController extends Controller
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
      'description' => 'required|max:25'
    ]);
  }

  /**
   * Display a listing of the priority tickets resources.
   *
   * @return App\Helpers\MakeResponse
   * @authenticated 
   * @apiResourceCollection App\Http\Resources\PriorityTicketCollection
   * @apiResourceModel App\Models\PriorityTicket
   */
  public function index()
  {

    try {
      if (!request()->isJson())
        return $this->response->unauthorized();

      $priorityTickets = new PriorityTicketCollection(PriorityTicket::all());

      return $this->response->success($priorityTickets);
    } catch (\Exception $exception) {

      return $this->response->exception($exception->getMessage());
    }
  }

  /**
   * Store a newly created resource in storage.
   *
   *  @return App\Helpers\MakeResponse
   * @authenticated 
   * @apiResourceCollection App\Http\Resources\Json\PriorityTicket
   * @apiResourceModel App\Models\PriorityTicket
   */
  public function store()
  {

    try {
      if (!request()->isJson())
        return $this->response->unauthorized();

      $validate = $this->validateData(request()->all());

      if ($validate->fails())
        return $this->response->exception(($validate->errors()));

      $priorityTicket = new PriorityTicket();

      $priorityTicket = $priorityTicket->create(request()->all());

      return $this->response->created($priorityTicket->format());
    } catch (\Exception $exception) {

      return $this->response->exception($exception->getMessage());
    }
  }

  /**
   * Display the specified resource.
   *
   * @param  int  $priority_ticket
   *  @return App\Helpers\MakeResponse
   * @authenticated 
   * @apiResourceCollection App\Http\Resources\Json\PriorityTicket
   * @apiResourceModel App\Models\PriorityTicket
   * 
   * @urlParam priority_ticket required The ID of the priority ticket resource.
   */
  public function show($priority_ticket)
  {

    try {
      if (!request()->isJson())
        return $this->response->unauthorized();

      if (!is_numeric($priority_ticket))
        return $this->response->badRequest();

      $priorityTicketModel = PriorityTicket::find($priority_ticket);

      if (!isset($priorityTicketModel))
        return $this->response->noContent();

      return $this->response->success($priorityTicketModel->format());
    } catch (\Exception $exception) {

      return $this->response->exception($exception->getMessage());
    }
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  int  $priority_ticket
   *  @return App\Helpers\MakeResponse
   * @authenticated 
   * @apiResourceCollection App\Http\Resources\Json\PriorityTicket
   * @apiResourceModel App\Models\PriorityTicket
   * 
   * @urlParam priority_ticket required The ID of the priority ticket resource.
   */
  public function update($priority_ticket)
  {

    try {
      if (!request()->isJson())
        return $this->response->unauthorized();

      if (!is_numeric($priority_ticket))
        return $this->response->badRequest();

      $priorityTicketModel = PriorityTicket::find($priority_ticket);

      if (!isset($priorityTicketModel))
        return $this->response->noContent();

      $validate = $this->validateData(request()->all());

      if ($validate->fails())
        return $this->response->exception($validate->errors());

      $priorityTicketModel->update(request()->all());

      return $this->response->success($priorityTicketModel->fresh()->format());
    } catch (\Exception $exception) {

      return $this->response->exception($exception->getMessage());
    }
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $priority_ticket
   *  @return App\Helpers\MakeResponse
   * @authenticated 
   * 
   * @urlParam priority_ticket required The ID of the priority ticket resource.
   */
  public function destroy($priority_ticket)
  {

    try {
      if (!request()->isJson())
        return $this->response->unauthorized();

      if (!is_numeric($priority_ticket))
        return $this->response->badRequest();

      $priorityTicketModel = PriorityTicket::find($priority_ticket);

      if (!isset($priorityTicketModel))
        return $this->response->noContent();

      $priorityTicketModel->delete();

      return $this->response->success(null);
    } catch (\Exception $exception) {

      return $this->response->exception($exception->getMessage());
    }
  }

  /**
   * Display a list of tickets resources related to priority ticket resource.
   *
   * @param  int  $type_ticket
   * @return App\Helpers\MakeResponse
   * 
   * @authenticated 
   * @response {
   *  "priorityTicket": "priorityTicket",
   *  "relationships":{
   *    "links": {"href": "url", "rel": "/rels/tickets"},
   *    "collections": {"numberOfElements": "number", "data": "array"}
   *   }
   * }
   * 
   * @urlParam priority_ticket required The ID of the priority ticket resource.
   */
  public function tickets($priority_ticket)
  {
    try {
      if (!request()->isJson())
        return $this->response->unauthorized();

      $priorityTicketModel = PriorityTicket::find($priority_ticket);

      if (!isset($priorityTicketModel))
        return $this->response->noContent();

      $priorityTicketFormated = new JsonPriorityTicket($priorityTicketModel);

      $priorityTicketFormated->tickets = [
        'priorityTicket' => $priorityTicketFormated,
        'relationships' => [
          'links' => [
            'href' => route(
              'api.priorityTickets.tickets',
              ['priority_ticket' => $priorityTicketFormated->id],
              false
            ),
            'rel' => '/rels/tickets',
          ],
          'collection' => [
            'numberOfElements' => $priorityTicketFormated->tickets->count(),
            'data' => $priorityTicketFormated->tickets->map(function ($ticket) {
              return new JsonTicket($ticket);
            })

          ]
        ]
      ];

      return $this->response->success($priorityTicketFormated->tickets);
    } catch (\Exception $exception) {

      return $this->response->exception($exception->getMessage());
    }
  }
}
