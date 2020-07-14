<?php

namespace App\Http\Controllers;

use App\Helpers\MakeResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\SectionCollection;
use App\Models\Section;

class SectionController extends Controller
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
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    try {

      if (!request()->isJson())
        return $this->response->unauthorized();

      $collection = new SectionCollection(Section::all());

      return $this->response->success($collection);
    } catch (\Exception $exception) {

      return $this->response->exception($exception->getMessage());
    }
  }

  /**
   * Store a newly created resource in storage.
   *
   *  @return App\Helpers\MakeResponse
   * @authenticated 
   * @apiResourceCollection App\Http\Resources\Json\Section
   * @apiResourceModel App\Models\Section
   */
  public function store(Request $request)
  {
    try {

      if (!request()->isJson())
        return $this->response->unauthorized();

      $validate = $this->validateData(request()->all());

      if ($validate->fails())
        return $this->response->exception($validate->errors());

      $section = new Section();

      $section = $section->create(request()->all());

      return $this->response->created($section->format());
    } catch (\Exception $exception) {

      return $this->response->exception($exception->getMessage());
    }
  }

  /**
   * Display the specified resource.
   *
   * @param  int  $section
   * @return App\Helpers\MakeResponse
   * @authenticated 
   * @apiResourceCollection App\Http\Resources\Json\Section
   * @apiResourceModel App\Models\Section
   * 
   * @urlParam section required The ID of the section resource.
   */
  public function show($section)
  {
    try {

      if (!request()->isJson())
        return $this->response->unauthorized();

      if (!is_numeric($section))
        return $this->response->badRequest();

      $sectionModel = Section::find($section);

      if (!isset($sectionModel))
        return $this->response->noContent();

      return $this->response->success($sectionModel->format());
    } catch (\Exception $exception) {

      return $this->response->exception($exception->getMessage());
    }
  }


  /**
   * Update the specified resource in storage.
   *
   * @param  int  $section
   * @return App\Helpers\MakeResponse
   * @authenticated 
   * @apiResourceCollection App\Http\Resources\Json\Section
   * @apiResourceModel App\Models\Section
   * 
   * @urlParam section required The ID of the section resource.
   */
  public function update(Request $request, $section)
  {
    try {

      if (!request()->isJson())
        return $this->response->unauthorized();

      if (!is_numeric($section))
        return $this->response->badRequest();

      $sectionModel = Section::find($section);

      if (!isset($sectionModel))
        return $this->response->noContent();

      $validate = $this->validateData(request()->all());

      if ($validate->fails())
        return $this->response->exception($validate->errors());

      $sectionModel->update(request()->all());

      return $this->response->success($sectionModel->fresh()->format());
    } catch (\Exception $exception) {

      return $this->response->exception($exception->getMessage());
    }
  }


  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $section
   * @return App\Helpers\MakeResponse
   * @authenticated 
   * 
   * @urlParam section required The ID of the section resource.
   */
  public function destroy($section)
  {
    try {

      if (!request()->isJson())
        return $this->response->unauthorized();

      if (!is_numeric($section))
        return $this->response->badRequest();

      $sectionModel = Section::find($section);

      if (!isset($sectionModel))
        return $this->response->noContent();

      $sectionModel->delete();

      return $this->response->success(null);
    } catch (\Exception $exception) {

      return $this->response->exception($exception->getMessage());
    }
  }
}
