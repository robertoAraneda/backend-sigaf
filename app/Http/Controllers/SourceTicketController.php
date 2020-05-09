<?php

namespace App\Http\Controllers;

use App\Helpers\MakeResponse;
use App\Http\Resources\Json\SourceTicket as JsonSourceTicket;
use App\Http\Resources\Json\Ticket as JsonTicket;
use App\Http\Resources\SourceTicketCollection;
use App\Models\SourceTicket;
use Illuminate\Support\Facades\Validator;

class SourceTicketController extends Controller
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
   * Display a listing of the resource.
   *
   * @return App\Helpers\MakeResponse
   * @authenticated 
   * @apiResourceCollection App\Http\Resources\SourceTicketCollection
   * @apiResourceModel App\Models\SourceTicket
   */
  public function index()
  {
    try {

      if (!request()->isJson())
        return $this->response->unauthorized();

      $sourceTickets = new SourceTicketCollection(SourceTicket::all());

      return $this->response->success($sourceTickets);
    } catch (\Exception $exception) {

      return $this->response->exception($exception->getMessage());
    }
  }

  /**
   * Store a newly created resource in storage.
   *
   * @return App\Helpers\MakeResponse
   * @authenticated 
   * @apiResourceCollection App\Http\Resources\Json\SourceTicket
   * @apiResourceModel App\Models\SourceTicket
   */
  public function store()
  {
    try {

      if (!request()->isJson())
        return $this->response->unauthorized();

      $validate = $this->validateData(request()->all());

      if ($validate->fails())
        return $this->response->exception($validate->errors());

      $sourceTicket = new SourceTicket();

      $sourceTicket = $sourceTicket->create(request()->all());

      return $this->response->created($sourceTicket->format());
    } catch (\Exception $exception) {

      return $this->response->exception($exception->getMessage());
    }
  }

  /**
   * Display the specified resource.
   *
   * @param  int  $source_ticket
   * @return App\Helpers\MakeResponse
   * @authenticated 
   * @apiResourceCollection App\Http\Resources\Json\SourceTicket
   * @apiResourceModel App\Models\SourceTicket
   * 
   * @urlParam source_ticket required The ID of the source ticket resource.
   */
  public function show($source_ticket)
  {
    try {

      if (!request()->isJson())
        return $this->response->unauthorized();

      if (!is_numeric($source_ticket))
        return $this->response->badRequest();

      $sourceTicketModel = SourceTicket::find($source_ticket);

      if (!isset($sourceTicketModel))
        return $this->response->noContent();

      return $this->response->success($sourceTicketModel->format());
    } catch (\Exception $exception) {

      return $this->response->exception($exception->getMessage());
    }
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  int  $source_ticket
   * @return App\Helpers\MakeResponse
   * @authenticated 
   * @apiResourceCollection App\Http\Resources\Json\SourceTicket
   * @apiResourceModel App\Models\SourceTicket
   * 
   * @urlParam source_ticket required The ID of the source ticket resource.
   */
  public function update($source_ticket)
  {
    try {

      if (!request()->isJson())
        return $this->response->unauthorized();

      if (!is_numeric($source_ticket))
        return $this->response->badRequest();

      $sourceTicketModel = SourceTicket::find($source_ticket);

      if (!isset($sourceTicketModel))
        return $this->response->noContent();

      $validate = $this->validateData(request()->all());

      if ($validate->fails())
        return $this->response->exception($validate->errors());

      $sourceTicketModel->update(request()->all());

      return $this->response->success($sourceTicketModel->fresh()->format());
    } catch (\Exception $exception) {

      return $this->response->exception($exception->getMessage());
    }
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $source_ticket
   * @return App\Helpers\MakeResponse
   * @authenticated 
   * 
   * @urlParam source_ticket required The ID of the source ticket resource.
   */
  public function destroy($source_ticket)
  {
    try {

      if (!request()->isJson())
        return $this->response->unauthorized();

      if (!is_numeric($source_ticket))
        return $this->response->badRequest();

      $sourceTicketModel = SourceTicket::find($source_ticket);

      if (!isset($sourceTicketModel))
        return $this->response->noContent();

      $sourceTicketModel->delete();

      return $this->response->success(null);
    } catch (\Exception $exception) {

      return $this->response->exception($exception->getMessage());
    }
  }

  /**
   * Display a list of tickets resources related to source ticket resource.
   *
   * @param  int  $source_ticket
   * @return App\Helpers\MakeResponse
   * 
   * @authenticated 
   * @response {
   *  "sourceTicket": "sourceTicket",
   *  "relationships":{
   *    "links": {"href": "url", "rel": "/rels/tickets"},
   *    "collections": {"numberOfElements": "number", "data": "array"}
   *   }
   * }
   * 
   * @urlParam source_ticket required The ID of the source ticket resource.
   */
  public function tickets($source_ticket)
  {
    try {
      if (!request()->isJson())
        return $this->response->unauthorized();

      $sourceTicketModel = SourceTicket::find($source_ticket);

      if (!isset($sourceTicketModel))
        return $this->response->noContent();

      $sourceTicketFormated = new JsonSourceTicket($sourceTicketModel);

      $sourceTicketFormated->tickets = [
        'sourceTicket' => $sourceTicketFormated,
        'relationships' => [
          'links' => [
            'href' => route(
              'api.sourceTickets.tickets',
              ['source_ticket' => $sourceTicketFormated->id],
              false
            ),
            'rel' => '/rels/tickets'
          ],
          'collection' => [
            'numberOfElements' => $sourceTicketFormated->tickets->count(),
            'data' => $sourceTicketFormated->tickets->map(function ($ticket) {
              return new JsonTicket($ticket);
            })
          ]
        ]
      ];

      return $this->response->success($sourceTicketFormated->tickets);
    } catch (\Exception $exception) {

      return $this->response->exception($exception->getMessage());
    }
  }
}
