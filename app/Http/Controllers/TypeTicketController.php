<?php

namespace App\Http\Controllers;

use App\Helpers\MakeResponse;
use App\Http\Resources\TypeTicketCollection;
use App\Models\TypeTicket;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\Json\TypeTicket as JsonTypeTicket;
use App\Http\Resources\Json\Ticket as JsonTicket;

class TypeTicketController extends Controller
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
   * Display a listing of the type tickets resources.
   *
   * @return App\Helpers\MakeResponse
   * @authenticated 
   * @apiResourceCollection App\Http\Resources\TypeTicketCollection
   * @apiResourceModel App\Models\TypeTicket
   */
  public function index()
  {
    try {

      if (!request()->isJson())
        return $this->response->unauthorized();

      $typeTickets = new TypeTicketCollection(TypeTicket::all());

      return $this->response->success($typeTickets);
    } catch (\Exception $exception) {

      return $this->response->exception($exception->getMessage());
    }
  }

  /**
   * Store a newly created resource in storage.
   *
   *  @return App\Helpers\MakeResponse
   * @authenticated 
   * @apiResourceCollection App\Http\Resources\Json\TypeTicket
   * @apiResourceModel App\Models\TypeTicket
   */
  public function store()
  {
    try {

      if (!request()->isJson())
        return $this->response->unauthorized();

      $validate = $this->validateData(request()->all());

      if ($validate->fails())
        return $this->response->exception($validate->errors());

      $typeTicket = new TypeTicket();

      $typeTicket = $typeTicket->create(request()->all());

      return $this->response->created($typeTicket->format());
    } catch (\Exception $exception) {

      return $this->response->exception($exception->getMessage());
    }
  }

  /**
   * Display the specified resource.
   *
   * @param  int  $type_tiicket
   * @return App\Helpers\MakeResponse
   * @authenticated 
   * @apiResourceCollection App\Http\Resources\Json\TypeTicket
   * @apiResourceModel App\Models\TypeTicket
   * 
   * @urlParam type_ticket required The ID of the type ticket resource.
   */
  public function show($type_ticket)
  {
    try {

      if (!request()->isJson())
        return $this->response->unauthorized();

      if (!is_numeric($type_ticket))
        return $this->response->badRequest();

      $typeTicketModel = TypeTicket::find($type_ticket);

      if (!isset($typeTicketModel))
        return $this->response->noContent();

      return $this->response->success($typeTicketModel->format());
    } catch (\Exception $exception) {

      return $this->response->exception($exception->getMessage());
    }
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  int  $type_ticket
   * @return App\Helpers\MakeResponse
   * @authenticated 
   * @apiResourceCollection App\Http\Resources\Json\TypeTicket
   * @apiResourceModel App\Models\TypeTicket
   * 
   * @urlParam type_ticket required The ID of the type ticket resource.
   */
  public function update($type_ticket)
  {
    try {

      if (!request()->isJson())
        return $this->response->unauthorized();

      if (!is_numeric($type_ticket))
        return $this->response->badRequest();

      $typeTicketModel = TypeTicket::find($type_ticket);

      if (!isset($typeTicketModel))
        return $this->response->noContent();

      $validate = $this->validateData(request()->all());

      if ($validate->fails())
        return $this->response->exception($validate->errors());

      $typeTicketModel->update(request()->all());

      return $this->response->success($typeTicketModel->fresh()->format());
    } catch (\Exception $exception) {

      return $this->response->exception($exception->getMessage());
    }
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $type_ticket
   * @return App\Helpers\MakeResponse
   * @authenticated 
   * 
   * @urlParam type_ticket required The ID of the type ticket resource.
   */
  public function destroy($type_ticket)
  {
    try {

      if (!request()->isJson())
        return $this->response->unauthorized();

      if (!is_numeric($type_ticket))
        return $this->response->badRequest();

      $typeTicketModel = TypeTicket::find($type_ticket);

      if (!isset($typeTicketModel))
        return $this->response->noContent();

      $typeTicketModel->delete();

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
  public function tickets($type_ticket)
  {
    try {
      if (!request()->isJson())
        return $this->response->unauthorized();

      $typeTicketModel = TypeTicket::find($type_ticket);

      if (!isset($typeTicketModel))
        return $this->response->noContent();

      $typeTicketFormated = new JsonTypeTicket($typeTicketModel);

      $typeTicketFormated->tickets = [
        'typeTicket' => $typeTicketFormated,
        'relationships' => [
          'links' => [
            'href' => route(
              'api.typeTickets.tickets',
              ['type_ticket' => $typeTicketFormated->id],
              false
            ),
            'rel' => '/rels/tickets'
          ],
          'collection' => [
            'numberOfElements' => $typeTicketFormated->tickets->count(),
            'data' => $typeTicketFormated->tickets->map(function ($ticket) {
              return new JsonTicket($ticket);
            })
          ]
        ]
      ];

      return $this->response->success($typeTicketFormated->tickets);
    } catch (\Exception $exception) {
      return $this->response->exception($exception->getMessage());
    }
  }
}
