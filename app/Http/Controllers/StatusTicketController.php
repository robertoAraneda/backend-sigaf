<?php

namespace App\Http\Controllers;

use App\Helpers\MakeResponse;
use App\Http\Resources\Json\StatusTicket as JsonStatusTicket;
use App\Http\Resources\Json\Ticket as JsonTicket;
use App\Http\Resources\StatusTicketCollection;
use App\Models\StatusTicket;
use Illuminate\Support\Facades\Validator;

class StatusTicketController extends Controller
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
   * Display a listing of the status tickets resources.
   *
   * @return App\Helpers\MakeResponse
   * @authenticated 
   * @apiResourceCollection App\Http\Resources\StatusTicketCollection
   * @apiResourceModel App\Models\StatusTicket
   */
  public function index()
  {
    try {

      if (!request()->isJson())
        return $this->response->unauthorized();

      $statusTickets = new StatusTicketCollection(StatusTicket::all());

      return $this->response->success($statusTickets);
    } catch (\Exception $exception) {

      return $this->response->exception($exception->getMessage());
    }
  }

  /**
   * Store a newly created resource in storage.
   *
   *  @return App\Helpers\MakeResponse
   * @authenticated 
   * @apiResourceCollection App\Http\Resources\Json\StatusTicket
   * @apiResourceModel App\Models\StatusTicket
   */
  public function store()
  {
    try {
      if (!request()->isJson())
        return $this->response->unauthorized();

      $validate = $this->validateData(request()->all());

      if ($validate->fails())
        return $this->response->exception($validate->errors());

      $statusTicket = new StatusTicket();

      $statusTicket = $statusTicket->create(request()->all());

      return $this->response->created($statusTicket->format());
    } catch (\Exception $exception) {

      return $this->response->exception($exception->getMessage());
    }
  }

  /**
   * Display the specified resource.
   *
   * @param  int  $statusTicket
   * @return App\Helpers\MakeResponse
   * @authenticated 
   * @apiResourceCollection App\Http\Resources\Json\StatusTicket
   * @apiResourceModel App\Models\StatusTicket
   * 
   * @urlParam status_ticket required The ID of the status ticket resource.
   */
  public function show($status_ticket)
  {
    try {
      if (!request()->isJson())
        return $this->response->unauthorized();

      if (!is_numeric($status_ticket))
        return $this->response->badRequest();

      $statusTicketModel = StatusTicket::find($status_ticket);

      if (!isset($statusTicketModel))
        return $this->response->noContent();

      return $this->response->success($statusTicketModel->format());
    } catch (\Exception $exception) {

      return $this->response->exception($exception->getMessage());
    }
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  int  $statusTicket
   * @return App\Helpers\MakeResponse
   * @authenticated 
   * @apiResourceCollection App\Http\Resources\Json\StatusTicket
   * @apiResourceModel App\Models\StatusTicket
   * 
   * @urlParam status_ticket required The ID of the status ticket resource.
   */
  public function update($status_ticket)
  {

    try {
      if (!request()->isJson())
        return $this->response->unauthorized();

      if (!is_numeric($status_ticket))
        return $this->response->badRequest();

      $statusTicketModel = StatusTicket::find($status_ticket);

      if (!isset($statusTicketModel))
        return $this->response->noContent();

      $validate = $this->validateData(request()->all());

      if ($validate->fails())
        return $this->response->exception($validate->errors());

      $statusTicketModel->update(request()->all());

      return $this->response->success($statusTicketModel->fresh()->format());
    } catch (\Exception $exception) {

      return $this->response->exception($exception->getMessage());
    }
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $statusTicket
   * @return App\Helpers\MakeResponse
   * @authenticated 
   * 
   * @urlParam status_ticket required The ID of the status ticket resource.
   */
  public function destroy($status_ticket)
  {

    try {
      if (!request()->isJson())
        return $this->response->unauthorized();

      if (!is_numeric($status_ticket))
        return $this->response->badRequest();

      $statusTicketModel = StatusTicket::find($status_ticket);

      if (!isset($statusTicketModel))
        return $this->response->noContent();

      $statusTicketModel->delete();

      return $this->response->success(null);
    } catch (\Exception $exception) {

      return $this->response->exception($exception->getMessage());
    }
  }

  /**
   * Display a list of tickets resources related to status ticket resource.
   *
   * @param  int  $statusTicket
   * @return App\Helpers\MakeResponse
   * 
   * @authenticated 
   * @response {
   *  "statusTicket": "statusTicket",
   *  "relationships":{
   *    "links": {"href": "url", "rel": "/rels/tickets"},
   *    "collections": {"numberOfElements": "number", "data": "array"}
   *   }
   * }
   * 
   * @urlParam status_ticket required The ID of the status ticket resource.
   */
  public function tickets($status_ticket)
  {
    try {
      if (!request()->isJson())
        return $this->response->unauthorized();

      $statusTicketModel = StatusTicket::find($status_ticket);

      if (!isset($statusTicketModel))
        return $this->response->noContent();

      $statusTicketFormated = new JsonStatusTicket($statusTicketModel);

      $statusTicketFormated->tickets = [
        'statusTicket' => $statusTicketFormated,
        'relationships' => [
          'links' => [
            'href' => route(
              'api.statusTickets.tickets',
              ['status_ticket' => $statusTicketFormated->id],
              false
            ),
            'rel' => '/rels/tickets',
          ],
          'collection' => [
            'numberOfElements' => $statusTicketFormated->tickets->count(),
            'collection' => $statusTicketFormated->tickets->map(function ($ticket) {
              return new JsonTicket($ticket);
            })
          ]
        ]
      ];

      return $this->response->success($statusTicketFormated->tickets);
    } catch (\Exception $exception) {

      return $this->response->exception($exception->getMessage());
    }
  }
}
