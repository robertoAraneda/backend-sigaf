<?php

namespace App\Http\Controllers;

use App\Helpers\MakeResponse;
use App\Http\Resources\Json\StatusDetailTicket as JsonStatusDetailTicket;
use App\Http\Resources\Json\TicketDetail as JsonTicketDetail;
use App\Http\Resources\StatusDetailTicketCollection;
use App\Models\StatusDetailTicket;
use Illuminate\Support\Facades\Validator;




class StatusDetailTicketController extends Controller
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
   * Display a listing of the resource the status details ticket.
   *
   * @return App\Helpers\MakeResponse
   * @authenticated 
   * @apiResourceCollection App\Http\Resources\Json\StatusDetailTicketCollection
   * @apiResourceModel App\Models\StatusDetailTicket
   */
  public function index()
  {

    try {

      if (!request()->isJson())
        return $this->response->unauthorized();

      $statusDetailTickets = new StatusDetailTicketCollection(StatusDetailTicket::all());

      return $this->response->success($statusDetailTickets);
    } catch (\Exception $exception) {

      return $this->response->exception($exception->getMessage());
    }
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param App\Helpers\MakeResponse
   * @authenticated 
   * @apiResourceCollection App\Http\Resources\Json\StatusDetailTicketCollection
   * @apiResourceModel App\Models\StatusDetailTicket
   */
  public function store()
  {

    try {

      if (!request()->isJson())
        return $this->response->unauthorized();

      $validate = $this->validateData(request()->all());

      if ($validate->fails())
        return $this->response->exception($validate->errors());

      $statusDetailTicket = new StatusDetailTicket();

      $statusDetailTicket = $statusDetailTicket->create(request()->all());

      return $this->response->created($statusDetailTicket->format());
    } catch (\Exception $exception) {

      return $this->response->exception($exception->getMessage());
    }
  }

  /**
   * Display the specified resource.
   *
   * @param  int  $status_detail_ticket
   * @return App\Helpers\MakeResponse
   * @authenticated 
   * @apiResourceCollection App\Http\Resources\Json\StatusDetailTicket
   * @apiResourceModel App\Models\StatusDetailTicket
   * 
   * @urlParam 
   * @param  int  status_detail_ticket required The ID of the status detail ticket resource.
   */
  public function show($status_detail_ticket)
  {

    try {

      if (!request()->isJson())
        return $this->response->unauthorized();

      if (!is_numeric($status_detail_ticket))
        return $this->response->badRequest();

      $statusDetailTicketModel = StatusDetailTicket::find($status_detail_ticket);

      if (!isset($statusDetailTicketModel))
        return $this->response->noContent();

      return $this->response->success($statusDetailTicketModel->format());
    } catch (\Exception $exception) {

      return $this->response->exception($exception->getMessage());
    }
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  int  $status_detail_ticket
   * @return App\Helpers\MakeResponse
   * @authenticated 
   * @apiResourceCollection App\Http\Resources\Json\StatusDetailTicket
   * @apiResourceModel App\Models\StatusDetailTicket
   * 
   * @urlParam status_detail_ticket required The ID of the status detail ticket resource.
   */
  public function update($status_detail_ticket)
  {

    try {

      if (!request()->isJson())
        return $this->response->unauthorized();

      if (!is_numeric($status_detail_ticket))
        return $this->response->badRequest();

      $statusDetailTicketModel = StatusDetailTicket::find($status_detail_ticket);

      if (!isset($statusDetailTicketModel))
        return $this->response->noContent();

      $validate = $this->validateData(request()->all());

      if ($validate->fails())
        return $this->response->exception($validate->errors());

      $statusDetailTicketModel->update(request()->all());

      return $this->response->success($statusDetailTicketModel->fresh()->format());
    } catch (\Exception $exception) {

      return $this->response->exception($exception->getMessage());
    }
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $status_detail_ticket
   * @return App\Helpers\MakeResponse
   * @authenticated 
   * 
   * @urlParam status_detail_ticket required The ID of the status detail ticket resource.
   */
  public function destroy($status_detail_ticket)
  {

    try {

      if (!request()->isJson())
        return $this->response->unauthorized();

      if (!is_numeric($status_detail_ticket))
        return $this->response->badRequest();

      $statusDetailTicketModel = StatusDetailTicket::find($status_detail_ticket);

      if (!isset($statusDetailTicketModel))
        return $this->response->noContent();

      $statusDetailTicketModel->delete();

      return $this->response->success(null);
    } catch (\Exception $exception) {

      return $this->response->exception($exception->getMessage());
    }
  }

  /**
   * Display a list of tickets resources related to type ticket resource.
   *
   * @param  int  $status_detail_ticket
   * @return App\Helpers\MakeResponse
   * 
   * @authenticated 
   * @response {
   *  "statusDetailTicket": "statusDetailTicket",
   *  "relationships":{
   *    "links": {"href": "url", "rel": "/rels/ticketDetails"},
   *    "collections": {"numberOfElements": "number", "data": "array"}
   *   }
   * }
   * 
   * @urlParam status_detail_ticket required The ID of the status detail ticket resource.
   */
  public function ticketDetails($status_detail_ticket)
  {
    try {
      if (!request()->isJson())
        return $this->response->unauthorized();

      if (!is_numeric($status_detail_ticket))
        return $this->response->badRequest();

      $statusDetailTicketModel = StatusDetailTicket::find($status_detail_ticket);

      if (!isset($statusDetailTicketModel))
        return $this->response->noContent();

      $statusDetailTicketFormated = new JsonStatusDetailTicket($statusDetailTicketModel);

      $statusDetailTicketFormated->ticketDetails = [
        'statusDetailTicket' => $statusDetailTicketFormated,
        'relationships' => [
          'links' => [
            'href' => route(
              'api.statusDetailTickets.ticketDetails',
              ['status_detail_ticket' => $statusDetailTicketFormated->id],
              false
            ),
            'rel' => '/rels/ticketDetails'
          ],
          'collection' => [
            'numberOfElements' => $statusDetailTicketFormated->ticketDetails->count(),
            'data' => $statusDetailTicketFormated->ticketDetails->map(function ($ticketDetail) {
              return new JsonTicketDetail($ticketDetail);
            })
          ]
        ]
      ];

      return $this->response->success($statusDetailTicketFormated->ticketDetails);
    } catch (\Exception $exception) {

      return $this->response->exception($exception->getMessage());
    }
  }
}
