<?php

namespace App\Http\Controllers;

use App\Models\Classroom;
use Illuminate\Http\Request;

class ClassroomController extends Controller
{

  protected function validateData()
  {
    return request()->validate([
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

      $classrooms = Classroom::orderBy('id')
        ->get()
        ->map
        ->format();

      return response()->json([
        'success' => true,
        'classrooms' => $classrooms,
        'error' => null,
      ], 200);
    } catch (\Exception $exception) {

      return response()->json([
        'success' => false,
        'classrooms' => null,
        'error' => $exception->getMessage()
      ], 500);
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

      $classroom = new Classroom();

      $classroom = $classroom->create($dataStore);

      return response()->json([
        'success' => true,
        'classroom' => $classroom->fresh()->format(),
        'error' => null,
      ], 201);
    } catch (\Exception $exception) {

      return response()->json([
        'success' => false,
        'classroom' => null,
        'error' => $exception->getMessage(),
      ], 500);
    }
    //
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

        $classroom = Classroom::whereId($id)->first();

        if (isset($classroom)) {

          return response()->json([
            'success' => true,
            'classroom' => $classroom->format(),
            'error' => null,
          ], 200);
        } else {

          return response()->json([
            'success' => false,
            'classroom' => null,
            'error' => 'No Content',
          ], 204);
        }
      } else {

        return response()->json([
          'success' => false,
          'classroom' => null,
          'error' => 'Bad Request',
        ], 400);
      }
    } catch (\Exception $exception) {

      return response()->json([
        'success' => false,
        'classroom' => null,
        'error' => $exception->getMessage(),
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
  public function update(Request $request, $id)
  {
    try {

      if (is_numeric($id)) {

        $dataUpdate = $this->validateData();

        $classroom = Classroom::whereId($id)->first();

        if (isset($classroom)) {

          $classroom->update($dataUpdate);

          return response()->json([
            'success' => true,
            'classroom' => $classroom->fresh()->format(),
            'error' => null
          ], 200);
        } else {

          return response()->json([
            'success' => false,
            'classroom' => null,
            'error' => 'No Content'
          ], 204);
        }
      } else {

        return response()->json([
          'success' => false,
          'classroom' => null,
          'error' => 'Bad Request'
        ], 400);
      }
    } catch (\Exception $exception) {

      return response()->json([
        'success' => false,
        'classroom' => null,
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

        $classroom = Classroom::whereId($id)->first();

        if (isset($classroom)) {

          $classroom->delete();

          return response()->json([
            'success' => true,
            'classroom' => null,
            'error' => null
          ], 200);
        } else {

          return response()->json([
            'success' => false,
            'classroom' => null,
            'error' => 'No Content'
          ], 204);
        }
      } else {

        return response()->json([
          'success' => false,
          'classroom' => null,
          'error' => 'Bad Request'
        ], 400);
      }
    } catch (\Exception $exception) {

      return response()->json([
        'success' => false,
        'classroom' => null,
        'error' => $exception->getMessage()
      ], 500);
    }
  }
}
