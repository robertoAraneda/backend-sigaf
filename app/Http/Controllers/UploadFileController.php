<?php

namespace App\Http\Controllers;

use App\Helpers\MakeResponse;
use App\Models\CourseRegisteredUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UploadFileController extends Controller
{
    protected $response;

    public function __construct(MakeResponse $makeResponse = null)
    {
        $this->response = $makeResponse;
    }

    public function fileSubmit(Request $request)
    {
        $upload_path = storage_path('app');
        $file_name = $request->file->getClientOriginalName();
        $generated_new_name = 'upload_student.' . $request->file->getClientOriginalExtension();
        $request->file->move($upload_path, $generated_new_name);

        $registeredUserController = new RegisteredUserController();

        $collection =  $registeredUserController->import();

        foreach ($collection as $userCourse) {
            $courseRegisteredUser = new CourseRegisteredUser();

            $courseRegisteredUser->registered_user_id = $userCourse->id;
            $courseRegisteredUser->course_id = $request->courseId;
            $courseRegisteredUser->profile_id = 1;
            $courseRegisteredUser->is_sincronized = 0;

            if (!$this->isCourseRegisteredUserStore($userCourse->id, $request->courseId)) {
                $courseRegisteredUser->save();
            }
        }

        // Storage::delete('upload_student.xlsx');

        return $this->response->success($collection);
    }

    public function uploadFileEmail(Request $request)
    {
        try {
            $upload_path        = storage_path('app');
            $name          = $request->file->getClientOriginalName();

            $file               = $request->file->move($upload_path, $name);
            $url = Storage::url($name);
            $size = Storage::size($name);
            $mime = $request->file->getClientMimeType();


            $data = [
                'url' => $url,
                'name' => $name,
                'size' => $size,
                'mime' => $mime
            ];

            return $this->response->success($data);
        } catch (\Exception $exception) {
            return $this->response->exception($exception->getMessage());
        }
    }


    public function removeFileEmail(Request $request)
    {
        try {
            Storage::delete($request->name);

            return $this->response->success(true);
        } catch (\Exception $exception) {
            return $this->response->exception($exception->getMessage());
        }
    }

    

    private function isCourseRegisteredUserStore($courseRegisteredUser, $courseId)
    {
        $courseUser = CourseRegisteredUser::where('registered_user_id', $courseRegisteredUser)->where('course_id', $courseId)->first();

        if (isset($courseUser)) {
            return true;
        } else {
            return false;
        }
    }
}
