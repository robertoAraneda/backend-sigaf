<?php

namespace App\Http\Controllers;

use App\Helpers\MakeResponse;
use App\Http\Resources\AlertCollection;
use App\Models\Alert;
use Illuminate\Support\Facades\Validator;

class AlertController extends Controller
{

  protected $response;

  public function __construct(MakeResponse $makeResponse)
  {
    $this->response = $makeResponse;
  }

  protected function validateData($request)
  {

    return Validator::make($request, [
      'ticket_id' => 'required|integer',
      'user_id' => 'required|integer',
      'time' => 'required',
      'date' => 'required',
      'status_reminder' => 'required|integer',
      'status_notification' => 'required|integer',
      'comment' => 'max:255'
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

      $alerts = new AlertCollection(Alert::all());

      return $this->response->success($alerts);
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

      $valitate = $this->validateData(request()->all());

      if ($valitate->fails())
        return $this->response->exception($valitate->errors());

      $alert = new Alert();

      $alert = $alert->create(request()->all());

      return $this->response->created($alert->format());
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
      if (!request()->isJson())
        return $this->response->unauthorized();

      if (!is_numeric($id))
        return $this->response->badRequest();

      $alert = Alert::find($id);

      if (!isset($alert))
        return $this->response->noContent();

      return $this->response->success($alert->format());
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
  public function update($id)
  {

    try {

      if (!request()->isJson())
        return $this->response->unauthorized();

      if (!is_numeric($id))
        return $this->response->badRequest();
      $alert = Alert::find($id);

      if (!isset($alert))
        return $this->response->noContent();

      $valitate = $this->validateData(request()->all());

      if ($valitate->fails())
        return $this->response->exception($valitate->errors());

      $alert->update(request()->all());

      return $this->response->success($alert->fresh()->format());
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
  public function destroy($id)
  {
    try {

      if (!request()->isJson())
        return $this->response->unauthorized();

      if (!is_numeric($id))
        return $this->response->badRequest();

      $alert = Alert::find($id);

      if (!isset($alert))
        return $this->response->noContent();

      $alert->delete();

      return $this->response->success(null);
    } catch (\Exception $exception) {

      return $this->response->exception($exception->getMessage());
    }
  }
}
